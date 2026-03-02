<?php

namespace App\Services\Pricing;

use App\Customer;
use App\PriceList;
use App\User;
use App\Models\Pricing\CustomerPriceListAssignment;
use App\Models\Pricing\ProviderPriceListDefault;
use App\Models\Pricing\ResellerPriceListAssignment;
use Carbon\Carbon;
use RuntimeException;

/**
 * Resolves which PriceList to use for a purchase, following the hierarchy:
 *
 *   Customer default assignment
 *     → Reseller default assignment
 *       → Provider default assignment
 *
 * Only "active" price lists (not archived, not draft, within effective dates)
 * are considered usable.
 *
 * If no active price list is found at any level an exception is thrown with a
 * human-readable message so the caller can surface it to the user.
 */
class PriceListResolver
{
    // ── Primary explicit API ─────────────────────────────────────────────────

    /**
     * Resolve the best matching price list given explicit IDs and context.
     *
     * This is the canonical resolution method. All other public resolution
     * methods delegate to this one.
     *
     * Resolution order:
     *   1. Customer override  (if $customerId provided)
     *   2. Reseller default   (if $resellerId provided)
     *   3. Provider default   (always attempted as final fallback)
     *
     * @param  int          $providerId   Provider (MSP) that owns the price lists.
     * @param  int|null     $resellerId   Reseller in the hierarchy, or null for direct model.
     * @param  int|null     $customerId   Customer purchasing, or null for reseller-level view.
     * @param  string|null  $market       e.g. "ES" — null means "match any".
     * @param  string|null  $currency     e.g. "EUR" — null means "match any".
     * @param  string|null  $listType     "license_based" | "azure_consumption" | "one_time" | null.
     * @param  Carbon|null  $date         Effective date window check; defaults to now().
     *
     * @throws RuntimeException when no active provider default exists.
     */
    public function resolveForPurchase(
        int     $providerId,
        ?int    $resellerId,
        ?int    $customerId,
        ?string $market    = null,
        ?string $currency  = null,
        ?string $listType  = null,
        ?Carbon $date      = null,
    ): PriceList {
        $date ??= now();

        // 1) Customer override
        if ($customerId !== null) {
            $pl = $this->resolveCustomerDefault($customerId, $providerId, $market, $currency, $listType, $date);
            if ($pl) {
                return $pl;
            }
        }

        // 2) Reseller default
        if ($resellerId !== null) {
            $pl = $this->resolveResellerDefault($resellerId, $providerId, $market, $currency, $listType, $date);
            if ($pl) {
                return $pl;
            }
        }

        // 3) Provider default
        $pl = $this->resolveProviderDefault($providerId, $market, $currency, $listType, $date);
        if ($pl) {
            return $pl;
        }

        $label = implode('/', array_filter([$market, $currency, $listType])) ?: '(any)';
        throw new RuntimeException(
            "No active provider default price list assigned for {$label}."
        );
    }

    // ── User-aware convenience wrappers ──────────────────────────────────────

    /**
     * Resolve for a customer purchase using User + Customer Eloquent objects.
     *
     * Kept for backward compatibility; delegates to resolveForPurchase().
     *
     * @param  array{
     *   provider_id?: int|null,
     *   market?: string|null,
     *   currency?: string|null,
     *   list_type?: string|null,
     *   date?: Carbon|null
     * } $context
     * @throws RuntimeException
     */
    public function resolveForPurchaseByUser(User $user, Customer $customer, array $context = []): PriceList
    {
        $providerId = $context['provider_id'] ?? $this->inferProviderId($user);
        $resellerId = $customer->resellers()->first()?->id;

        return $this->resolveForPurchase(
            providerId:  $providerId,
            resellerId:  $resellerId ? (int) $resellerId : null,
            customerId:  (int) $customer->id,
            market:      $context['market']    ?? null,
            currency:    $context['currency']  ?? null,
            listType:    $context['list_type'] ?? null,
            date:        $context['date']      ?? null,
        );
    }

    /**
     * Resolve the price list for a reseller's storefront.
     * Falls back: reseller default → provider default.
     *
     * @throws RuntimeException
     */
    public function resolveForReseller(User $user, array $context = []): PriceList
    {
        $reseller   = $user->reseller;
        $providerId = $context['provider_id'] ?? $reseller?->provider_id ?? $this->inferProviderId($user);
        $market     = $context['market']     ?? null;
        $currency   = $context['currency']   ?? null;
        $listType   = $context['list_type']  ?? null;
        $date       = $context['date']       ?? now();

        $resellerId = $reseller?->id ? (int) $reseller->id : null;

        if ($resellerId !== null) {
            $pl = $this->resolveResellerDefault($resellerId, $providerId, $market, $currency, $listType, $date);
            if ($pl) {
                return $pl;
            }
        }

        $pl = $this->resolveProviderDefault($providerId, $market, $currency, $listType, $date);
        if ($pl) {
            return $pl;
        }

        $label = implode('/', array_filter([$market, $currency, $listType])) ?: '(any)';
        throw new RuntimeException(
            "No active price list found for {$label}. " .
            "Assign a provider default or a reseller price list."
        );
    }

    // ── Resolution helpers ───────────────────────────────────────────────────

    protected function resolveCustomerDefault(
        int $customerId, int $providerId,
        ?string $market, ?string $currency, ?string $listType,
        Carbon $date
    ): ?PriceList {
        $assignment = CustomerPriceListAssignment::where('customer_id', $customerId)
            ->where('provider_id', $providerId)
            ->where('is_default', true)
            ->when($market,   fn ($q) => $q->where('market', $market))
            ->when($currency, fn ($q) => $q->where('currency', $currency))
            ->when($listType, fn ($q) => $q->where('list_type', $listType))
            ->orderByDesc('updated_at')
            ->first();

        return $assignment ? $this->effectivePriceList($assignment->price_list_id, $date) : null;
    }

    protected function resolveResellerDefault(
        int $resellerId, int $providerId,
        ?string $market, ?string $currency, ?string $listType,
        Carbon $date
    ): ?PriceList {
        $assignment = ResellerPriceListAssignment::where('reseller_id', $resellerId)
            ->where('provider_id', $providerId)
            ->where('is_default', true)
            ->when($market,   fn ($q) => $q->where('market', $market))
            ->when($currency, fn ($q) => $q->where('currency', $currency))
            ->when($listType, fn ($q) => $q->where('list_type', $listType))
            ->orderByDesc('updated_at')
            ->first();

        return $assignment ? $this->effectivePriceList($assignment->price_list_id, $date) : null;
    }

    protected function resolveProviderDefault(
        int $providerId,
        ?string $market, ?string $currency, ?string $listType,
        Carbon $date
    ): ?PriceList {
        $record = ProviderPriceListDefault::where('provider_id', $providerId)
            ->where('is_default', true)
            ->when($market,   fn ($q) => $q->where('market', $market))
            ->when($currency, fn ($q) => $q->where('currency', $currency))
            ->when($listType, fn ($q) => $q->where('list_type', $listType))
            ->orderByDesc('updated_at')
            ->first();

        return $record ? $this->effectivePriceList($record->price_list_id, $date) : null;
    }

    /**
     * Return a PriceList if it is usable (active + within effective date window).
     */
    protected function effectivePriceList(int $priceListId, Carbon $date): ?PriceList
    {
        return PriceList::withoutGlobalScopes()
            ->effectiveOn($date)
            ->where('id', $priceListId)
            ->first();
    }

    // ── Context helpers ──────────────────────────────────────────────────────

    protected function inferProviderId(User $user): int
    {
        $id = $user->provider?->id
            ?? $user->reseller?->provider_id
            ?? null;

        if (! $id) {
            throw new RuntimeException('Cannot resolve provider from the authenticated user.');
        }

        return (int) $id;
    }

    // ── Convenience: build context from a product ────────────────────────────

    /**
     * Derive list_type from product type string.
     */
    public static function listTypeForProduct(string $productType): string
    {
        return match (strtolower($productType)) {
            'azure', 'azure_consumption', 'azureplan' => PriceList::LIST_TYPE_AZURE,
            'perpetual', 'one_time'                   => PriceList::LIST_TYPE_ONE_TIME,
            default                                   => PriceList::LIST_TYPE_LICENSE,
        };
    }
}
