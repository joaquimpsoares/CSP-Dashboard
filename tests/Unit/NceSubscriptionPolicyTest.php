<?php

namespace Tests\Unit;

use App\Subscription;
use App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy;
use Carbon\Carbon;
use Tests\TestCase;

class NceSubscriptionPolicyTest extends TestCase
{
    public function test_increase_is_allowed_immediate(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-02-28T10:00:00Z'));

        $policy = new NceSubscriptionPolicy();
        $local = new Subscription();
        $local->amount = 10;

        $pc = [
            'quantity' => 10,
            'creationDate' => '2026-02-01T00:00:00Z',
        ];

        $decision = $policy->evaluate($local, $pc, ['type' => 'quantity', 'new_quantity' => 15]);

        $this->assertTrue($decision['allowed']);
        $this->assertSame('immediate', $decision['mode']);
        $this->assertSame('INCREASE_ALLOWED', $decision['reason_code']);
    }

    public function test_decrease_within_7_days_is_allowed_immediate(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-02-05T10:00:00Z'));

        $policy = new NceSubscriptionPolicy();
        $local = new Subscription();
        $local->amount = 10;

        $pc = [
            'quantity' => 10,
            'creationDate' => '2026-02-01T00:00:00Z',
        ];

        $decision = $policy->evaluate($local, $pc, ['type' => 'quantity', 'new_quantity' => 9]);

        $this->assertTrue($decision['allowed']);
        $this->assertSame('immediate', $decision['mode']);
        $this->assertSame('DECREASE_WITHIN_WINDOW', $decision['reason_code']);
    }

    public function test_decrease_outside_7_days_is_scheduled(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-02-20T10:00:00Z'));

        $policy = new NceSubscriptionPolicy();
        $local = new Subscription();
        $local->amount = 10;

        $pc = [
            'quantity' => 10,
            'creationDate' => '2026-02-01T00:00:00Z',
        ];

        $decision = $policy->evaluate($local, $pc, ['type' => 'quantity', 'new_quantity' => 9]);

        $this->assertTrue($decision['allowed']);
        $this->assertSame('schedule', $decision['mode']);
        $this->assertSame('DECREASE_OUTSIDE_WINDOW', $decision['reason_code']);
    }

    public function test_decrease_unknown_window_is_scheduled_conservative(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-02-20T10:00:00Z'));

        $policy = new NceSubscriptionPolicy();
        $local = new Subscription();
        $local->amount = 10;

        $pc = [
            'quantity' => 10,
            // no dates
        ];

        $decision = $policy->evaluate($local, $pc, ['type' => 'quantity', 'new_quantity' => 9]);

        $this->assertTrue($decision['allowed']);
        $this->assertSame('schedule', $decision['mode']);
        $this->assertSame('DECREASE_WINDOW_UNKNOWN', $decision['reason_code']);
    }
}
