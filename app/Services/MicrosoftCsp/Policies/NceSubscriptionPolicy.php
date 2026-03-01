<?php

namespace App\Services\MicrosoftCsp\Policies;

use App\Subscription;
use Carbon\Carbon;

/**
 * NCE policy evaluator for Microsoft CSP subscription changes.
 *
 * Policy refs (docs for inline comments only):
 * - https://learn.microsoft.com/en-us/partner-center/developer/change-the-quantity-of-a-subscription
 * - https://learn.microsoft.com/en-us/partner-center/customers/new-commerce-cancellation-policy
 * - https://learn.microsoft.com/en-us/partner-center/customers/billing-frequency-changes
 * - https://learn.microsoft.com/en-us/partner-center/developer/create-scheduled-changes
 */
class NceSubscriptionPolicy
{
    public const MODE_IMMEDIATE = 'immediate';
    public const MODE_SCHEDULE = 'schedule';
    public const MODE_BLOCKED = 'blocked';

    /**
     * Evaluate a proposed change.
     *
     * @param array $pc Subscription details from Partner Center (or the Tagydes connector).
     *                 Expected keys when available: creationDate/startDate/commitmentEndDate/quantity/billingCycle/termDuration/status,
     *                 cancellationAllowedUntilDate (or CancellationAllowedUntil).
     * @param array $request
     *     - type: quantity|billing|term|cancel
     *     - new_quantity?: int
     *     - new_billing_cycle?: string
     *     - new_term_duration?: string
     */
    public function evaluate(Subscription $local, array $pc, array $request): array
    {
        $type = $request['type'] ?? 'quantity';

        return match ($type) {
            'quantity' => $this->evaluateQuantityChange($local, $pc, (int) ($request['new_quantity'] ?? $local->amount)),
            'billing' => $this->evaluateBillingChange($local, $pc, (string) ($request['new_billing_cycle'] ?? $local->billing_period)),
            'term' => $this->evaluateTermChange($local, $pc, (string) ($request['new_term_duration'] ?? $local->term)),
            'cancel' => $this->evaluateCancel($local, $pc),
            default => $this->blocked('UNKNOWN_CHANGE_TYPE', 'Unsupported change type.'),
        };
    }

    private function evaluateQuantityChange(Subscription $local, array $pc, int $newQuantity): array
    {
        $currentQuantity = (int) ($pc['quantity'] ?? $local->amount);

        // Always allow increases immediately.
        if ($newQuantity > $currentQuantity) {
            return $this->immediate('INCREASE_ALLOWED', 'Seat increases can be applied immediately.');
        }

        if ($newQuantity === $currentQuantity) {
            return $this->immediate('NOOP', 'No change.');
        }

        // Decreases: only within 7-day cancellation window.
        [$windowEnd, $confidence] = $this->computeDecreaseWindowEnd($pc);

        if (!$windowEnd) {
            // Conservative default.
            return $this->schedule(
                'DECREASE_WINDOW_UNKNOWN',
                "Seat reductions are only available within 7 days of purchase/renewal. We can't confirm you are within the 7-day window; schedule this reduction for renewal instead.",
                ['quantity' => $newQuantity],
                null
            );
        }

        if (Carbon::now()->lessThanOrEqualTo($windowEnd)) {
            return $this->immediate(
                'DECREASE_WITHIN_WINDOW',
                'Seat reduction is allowed because you are within the 7-day cancellation window.',
                $windowEnd
            );
        }

        // Outside the window => schedule at renewal.
        return $this->schedule(
            'DECREASE_OUTSIDE_WINDOW',
            'Seat reductions are only available within 7 days of purchase/renewal. You can schedule this reduction for renewal instead.',
            ['quantity' => $newQuantity],
            $windowEnd,
            $confidence
        );
    }

    private function evaluateBillingChange(Subscription $local, array $pc, string $newCycle): array
    {
        $current = (string) ($pc['billingCycle'] ?? $local->billing_period ?? '');
        if ($newCycle === $current) {
            return $this->immediate('NOOP', 'No change.');
        }

        // Default to scheduled changes at renewal (preferred).
        return $this->schedule(
            'BILLING_CHANGE_SCHEDULED',
            'Billing plan changes are applied at renewal. Schedule this change now and it will take effect on the renewal date.',
            ['billingCycle' => $newCycle],
            $this->tryParseDate($pc['commitmentEndDate'] ?? null)
        );
    }

    private function evaluateTermChange(Subscription $local, array $pc, string $newTermDuration): array
    {
        $current = (string) ($pc['termDuration'] ?? $local->term ?? '');
        if ($newTermDuration === $current) {
            return $this->immediate('NOOP', 'No change.');
        }

        // Prevent unsupported downgrades: be conservative and schedule.
        return $this->schedule(
            'TERM_CHANGE_SCHEDULED',
            'Term changes are applied at renewal. Schedule this change now and it will take effect on the renewal date.',
            ['termDuration' => $newTermDuration],
            $this->tryParseDate($pc['commitmentEndDate'] ?? null)
        );
    }

    private function evaluateCancel(Subscription $local, array $pc): array
    {
        [$windowEnd] = $this->computeDecreaseWindowEnd($pc);

        if ($windowEnd && Carbon::now()->lessThanOrEqualTo($windowEnd)) {
            return $this->immediate('CANCEL_WITHIN_WINDOW', 'Cancellation is allowed because you are within the 7-day cancellation window.', $windowEnd);
        }

        return $this->schedule(
            'CANCEL_SCHEDULED',
            'Cancellations are only immediate within 7 days of purchase/renewal. You can schedule cancellation for renewal instead.',
            ['cancel' => true],
            $this->tryParseDate($pc['commitmentEndDate'] ?? null),
            null
        );
    }

    /**
     * Returns [windowEnd, confidence].
     *
     * If Partner Center provides cancellationAllowedUntilDate, prefer it.
     * Otherwise infer from creationDate/startDate (conservative).
     */
    private function computeDecreaseWindowEnd(array $pc): array
    {
        $explicit = $pc['cancellationAllowedUntilDate']
            ?? $pc['CancellationAllowedUntil']
            ?? $pc['cancellationAllowedUntil']
            ?? null;

        if ($explicit) {
            $dt = $this->tryParseDate($explicit);
            return [$dt, 'explicit'];
        }

        // Infer from start/creation date when available.
        $start = $pc['startDate'] ?? $pc['creationDate'] ?? $pc['createdDate'] ?? null;
        $startDt = $this->tryParseDate($start);
        if (!$startDt) {
            return [null, 'unknown'];
        }

        return [$startDt->copy()->addDays(7), 'inferred'];
    }

    private function tryParseDate(mixed $value): ?Carbon
    {
        if (empty($value)) {
            return null;
        }
        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }

    private function immediate(string $code, string $message, ?Carbon $windowEndAt = null): array
    {
        return [
            'allowed' => true,
            'mode' => self::MODE_IMMEDIATE,
            'reason_code' => $code,
            'reason_message' => $message,
            'suggested_action' => null,
            'window_end_at' => $windowEndAt?->toIso8601String(),
        ];
    }

    private function schedule(string $code, string $message, array $payload, ?Carbon $windowEndAt = null, ?string $confidence = null): array
    {
        return [
            'allowed' => true,
            'mode' => self::MODE_SCHEDULE,
            'reason_code' => $code,
            'reason_message' => $message,
            'suggested_action' => [
                'type' => 'scheduled_change',
                'payload' => $payload,
                'confidence' => $confidence,
            ],
            'window_end_at' => $windowEndAt?->toIso8601String(),
        ];
    }

    private function blocked(string $code, string $message): array
    {
        return [
            'allowed' => false,
            'mode' => self::MODE_BLOCKED,
            'reason_code' => $code,
            'reason_message' => $message,
            'suggested_action' => null,
            'window_end_at' => null,
        ];
    }
}
