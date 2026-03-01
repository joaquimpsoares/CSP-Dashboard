<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\SubscriptionChangeController;
use App\Models\SubscriptionScheduledChange;
use App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy;
use App\Services\MicrosoftCsp\ScheduledChangesService;
use App\Subscription;
use App\User;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

/**
 * Controller-level tests for SubscriptionChangeController.
 *
 * These tests exercise the controller's logic in isolation from Partner Center:
 *   - NceSubscriptionPolicy  → mocked via Mockery (method injection)
 *   - ScheduledChangesService → mocked via Mockery (method injection)
 *   - Subscription::getSubscription() → mocked via partial Mockery
 *   - SubscriptionScheduledChange::create() → mocked via Mockery alias
 *
 * We extend Tests\TestCase (full Laravel app bootstrap) so that response(),
 * Auth, Log and other facades work, but we do NOT use RefreshDatabase —
 * no actual DB queries are executed.
 *
 * Run with:
 *   php artisan test --filter SubscriptionChangeControllerTest
 */
class SubscriptionChangeControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private SubscriptionChangeController $controller;
    private Subscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new SubscriptionChangeController();

        // Build a partial mock of Subscription that stubs getSubscription()
        // so no DB / Partner Center connection is needed.
        /** @var Subscription&\Mockery\MockInterface $sub */
        $sub = Mockery::mock(Subscription::class)->makePartial();
        $sub->shouldReceive('getSubscription')->andReturn(collect([]));

        // Set properties accessed by the controller's fetchPartnerCenterSubscription
        // and SubscriptionScheduledChange::create() call.
        $sub->id              = 99;
        $sub->subscription_id = 'pc-sub-unit-001';
        $sub->amount          = 10;
        $sub->billing_period  = 'monthly';
        $sub->term            = 'P1M';
        $sub->provider_id     = null;
        $sub->customer_id     = 1;
        $sub->expiration_data = null;

        // customer relation for getSubscription() args
        $tenantInfoMock = Mockery::mock();
        $tenantInfoMock->shouldReceive('first')->andReturn((object)['tenant_id' => 'tenant-001']);
        $customerMock = Mockery::mock();
        $customerMock->microsoftTenantInfo = $tenantInfoMock;
        $sub->shouldReceive('getAttribute')->with('customer')->andReturn($customerMock)->byDefault();

        $this->subscription = $sub;

        // Authenticate a stub user so Auth::user() has something to return.
        $user = new User();
        $user->id = 1;
        $user->email = 'test@example.com';
        $this->actingAs($user);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // validateChange() tests
    // ─────────────────────────────────────────────────────────────────────────

    public function test_validate_change_quantity_increase_returns_immediate(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'       => true,
                'mode'          => NceSubscriptionPolicy::MODE_IMMEDIATE,
                'reason_code'   => 'INCREASE_ALLOWED',
                'reason_message'=> 'Seat increases can be applied immediately.',
                'suggested_action' => null,
                'window_end_at' => null,
            ]);

        $response = $this->controller->validateChange(
            $this->makeRequest(['type' => 'quantity', 'new_quantity' => 15]),
            $this->subscription,
            $policy
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($data['allowed']);
        $this->assertSame('immediate', $data['mode']);
        $this->assertSame('INCREASE_ALLOWED', $data['reason_code']);
    }

    public function test_validate_change_quantity_decrease_outside_window_returns_schedule(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'       => true,
                'mode'          => NceSubscriptionPolicy::MODE_SCHEDULE,
                'reason_code'   => 'DECREASE_OUTSIDE_WINDOW',
                'reason_message'=> 'Seat reductions are only available within 7 days.',
                'suggested_action' => ['type' => 'scheduled_change', 'payload' => ['quantity' => 7], 'confidence' => 'inferred'],
                'window_end_at' => '2026-02-08T00:00:00+00:00',
            ]);

        $response = $this->controller->validateChange(
            $this->makeRequest(['type' => 'quantity', 'new_quantity' => 7]),
            $this->subscription,
            $policy
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('schedule', $data['mode']);
        $this->assertSame('DECREASE_OUTSIDE_WINDOW', $data['reason_code']);
    }

    public function test_validate_change_billing_change_returns_schedule(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'       => true,
                'mode'          => NceSubscriptionPolicy::MODE_SCHEDULE,
                'reason_code'   => 'BILLING_CHANGE_SCHEDULED',
                'reason_message'=> 'Billing plan changes are applied at renewal.',
                'suggested_action' => ['type' => 'scheduled_change', 'payload' => ['billingCycle' => 'annual'], 'confidence' => null],
                'window_end_at' => null,
            ]);

        $response = $this->controller->validateChange(
            $this->makeRequest(['type' => 'billing', 'new_billing_cycle' => 'annual']),
            $this->subscription,
            $policy
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('schedule', $data['mode']);
        $this->assertSame('BILLING_CHANGE_SCHEDULED', $data['reason_code']);
    }

    public function test_validate_change_term_change_returns_schedule(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'       => true,
                'mode'          => NceSubscriptionPolicy::MODE_SCHEDULE,
                'reason_code'   => 'TERM_CHANGE_SCHEDULED',
                'reason_message'=> 'Term changes are applied at renewal.',
                'suggested_action' => ['type' => 'scheduled_change', 'payload' => ['termDuration' => 'P1Y'], 'confidence' => null],
                'window_end_at' => null,
            ]);

        $response = $this->controller->validateChange(
            $this->makeRequest(['type' => 'term', 'new_term_duration' => 'P1Y']),
            $this->subscription,
            $policy
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('schedule', $data['mode']);
        $this->assertSame('TERM_CHANGE_SCHEDULED', $data['reason_code']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // scheduleChange() tests
    // ─────────────────────────────────────────────────────────────────────────

    public function test_schedule_change_returns_422_when_policy_says_immediate(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'          => true,
                'mode'             => NceSubscriptionPolicy::MODE_IMMEDIATE,
                'reason_code'      => 'INCREASE_ALLOWED',
                'reason_message'   => 'Seat increases can be applied immediately.',
                'suggested_action' => null,
                'window_end_at'    => null,
            ]);

        $scheduler = Mockery::mock(ScheduledChangesService::class);
        $scheduler->shouldNotReceive('schedule');

        $response = $this->controller->scheduleChange(
            $this->makeRequest(['type' => 'quantity', 'new_quantity' => 15]),
            $this->subscription,
            $policy,
            $scheduler
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(422, $response->getStatusCode());
        $this->assertFalse($data['ok']);
        $this->assertSame('This change is not eligible for scheduling.', $data['message']);
    }

    public function test_schedule_change_calls_scheduler_and_returns_ok(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'          => true,
                'mode'             => NceSubscriptionPolicy::MODE_SCHEDULE,
                'reason_code'      => 'DECREASE_OUTSIDE_WINDOW',
                'reason_message'   => 'Seat reductions outside the 7-day window.',
                'suggested_action' => ['type' => 'scheduled_change', 'payload' => ['quantity' => 7], 'confidence' => 'inferred'],
                'window_end_at'    => null,
            ]);

        $scheduler = Mockery::mock(ScheduledChangesService::class);
        $scheduler->shouldReceive('schedule')
            ->once()
            ->with($this->subscription, Mockery::type('array'))
            ->andReturn(['scheduledChangeId' => 'sc-001', 'status' => 'scheduled']);

        // Alias-mock the Eloquent static ::create() so it doesn't touch the DB.
        $scMock = Mockery::mock('alias:' . SubscriptionScheduledChange::class);
        $scMock->shouldReceive('create')
            ->once()
            ->with(Mockery::type('array'))
            ->andReturn((object)['id' => 42]);

        $response = $this->controller->scheduleChange(
            $this->makeRequest(['type' => 'quantity', 'new_quantity' => 7]),
            $this->subscription,
            $policy,
            $scheduler
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($data['ok']);
        $this->assertSame(42, $data['scheduled_change_id']);
    }

    public function test_schedule_change_records_failed_status_when_api_throws(): void
    {
        $policy = Mockery::mock(NceSubscriptionPolicy::class);
        $policy->shouldReceive('evaluate')
            ->once()
            ->andReturn([
                'allowed'          => true,
                'mode'             => NceSubscriptionPolicy::MODE_SCHEDULE,
                'reason_code'      => 'BILLING_CHANGE_SCHEDULED',
                'reason_message'   => 'Billing plan changes are applied at renewal.',
                'suggested_action' => ['type' => 'scheduled_change', 'payload' => ['billingCycle' => 'annual'], 'confidence' => null],
                'window_end_at'    => null,
            ]);

        $scheduler = Mockery::mock(ScheduledChangesService::class);
        $scheduler->shouldReceive('schedule')
            ->once()
            ->andThrow(new \RuntimeException('Partner Center error: 500'));

        $scMock = Mockery::mock('alias:' . SubscriptionScheduledChange::class);
        $scMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function (array $row) {
                $this->assertSame('failed', $row['status'], 'Status must be "failed" when API throws');
                $this->assertArrayHasKey('error', $row['api_response']);
                return true;
            }))
            ->andReturn((object)['id' => 99]);

        $response = $this->controller->scheduleChange(
            $this->makeRequest(['type' => 'billing', 'new_billing_cycle' => 'annual']),
            $this->subscription,
            $policy,
            $scheduler
        );

        $data = json_decode($response->getContent(), true);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertFalse($data['ok']);
        $this->assertSame(99, $data['scheduled_change_id']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Build a mock Request whose validate() is a no-op and input() reads from
     * the supplied data array. This avoids the HTTP routing + middleware stack.
     *
     * @param  array<string, mixed> $data
     */
    private function makeRequest(array $data): \Illuminate\Http\Request
    {
        /** @var \Illuminate\Http\Request&\Mockery\MockInterface $request */
        $request = Mockery::mock(\Illuminate\Http\Request::class)->makePartial();
        $request->shouldReceive('validate')->andReturn($data);
        $request->shouldReceive('input')->andReturnUsing(
            fn (string $key, $default = null) => $data[$key] ?? $default
        );

        return $request;
    }
}
