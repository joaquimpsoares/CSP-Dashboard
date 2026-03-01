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
 *
 * Context array keys (all optional — null means "match any"):
 *   provider_id  (int)    – resolved from the user/instance if omitted
 *   market       (string) – e.g. "ES"
 *   currency     (string) – e.g. "EUR"
 *   list_type    (string) – "license_based" | "azure_consumption" | "one_time" | null
 *   date         (Carbon) – defaults to now()
 */
class PriceListResolver
{
    // ── Public API ───────────────────────────────────────────────────────────

    /**
     * Resolve the best matching price list for a given customer and purchase context.
     *
     * @param  array{
     *   provider_id?: int|null,
     *   market?: string|null,
     *   currency?: string|null,
     *   list_type?: string|null,
     *   date?: Carbon|null
     * } $context
     * @throws RuntimeException when no usable price list exists
     */
    public function resolveForPurchase(User $user, Customer $customer, array $context = []): PriceList
    {
        $providerId = $context['provider_id'] ?? $this->inferProviderId($user);
        $market     = $context['market']     ?? null;
        $currency   = $context['currency']   ?? null;
        $listType   = $context['list_type']  ?? null;
        $date       = $context['date']       ?? now();

        // 1) Customer override
        $pl = $this->resolveCustomerDefault($customer->id, $providerId, $market, $currency, $listType, $date);
        if ($pl) {
            return $pl;
        }

        // 2) Reseller default
        $resellerId = $customer->resellers()->first()?->id;
        if ($resellerId) {
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
            "No active price list assigned for {$label}. " .
            "Assign a provider default or a reseller/customer price list."
        );
    }

    /**
     * Resolve the price list for a reseller's storefront (used by Store.php).
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

        $resellerId = $reseller?->id;
        if ($resellerId) {
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
