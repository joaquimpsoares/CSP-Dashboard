<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\BillingPortal\Session as PortalSession;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class BillingController extends Controller
{
    private function boot(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Resolve the flat-rate Stripe Price ID for the given plan / currency / interval.
     */
    private function priceId(string $plan, string $currency, string $interval): string
    {
        $intervalKey = $interval === 'year' ? 'ANNUAL' : 'MONTHLY';
        $envKey      = sprintf('STRIPE_PRICE_%s_%s_%s', strtoupper($plan), strtoupper($currency), $intervalKey);
        $price       = env($envKey);

        if (!$price) {
            throw new \RuntimeException("No Stripe price configured for env key: {$envKey}");
        }

        return $price;
    }

    /**
     * Resolve the metered Stripe Price ID for the given plan / currency.
     */
    private function usagePriceId(string $plan, string $currency): string
    {
        $envKey = sprintf('STRIPE_PRICE_%s_%s_USAGE', strtoupper($plan), strtoupper($currency));
        $price  = env($envKey);

        if (!$price) {
            throw new \RuntimeException("No Stripe usage price configured for env key: {$envKey}");
        }

        return $price;
    }

    /**
     * Create a Stripe Checkout Session and redirect the provider admin there.
     *
     * POST /billing/checkout
     * Body: plan (starter|growth|scale), currency (eur|usd), interval (month|year)
     */
    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan'     => 'required|in:starter,growth,scale',
            'currency' => 'required|in:eur,usd',
            'interval' => 'required|in:month,year',
        ]);

        $this->boot();

        $provider = $request->user()->provider;

        if (!$provider) {
            abort(403, 'No provider associated with your account.');
        }

        // Create a Stripe Customer on first checkout so the portal works later.
        if (!$provider->stripe_customer_id) {
            $customer = Customer::create([
                'email'    => $request->user()->email,
                'name'     => $provider->company_name,
                'metadata' => ['provider_id' => $provider->id],
            ]);
            $provider->update(['stripe_customer_id' => $customer->id]);
        }

        $session = Session::create([
            'customer'             => $provider->stripe_customer_id,
            'mode'                 => 'subscription',
            'currency'             => $validated['currency'],
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    // Flat-rate base fee
                    'price'    => $this->priceId($validated['plan'], $validated['currency'], $validated['interval']),
                    'quantity' => 1,
                ],
                [
                    // Metered usage (active CSP subscriptions) — no quantity; reported via UsageRecord
                    'price' => $this->usagePriceId($validated['plan'], $validated['currency']),
                ],
            ],
            'subscription_data' => [
                'metadata' => [
                    'provider_id' => $provider->id,
                    'plan'        => $validated['plan'],
                    'currency'    => $validated['currency'],
                    'interval'    => $validated['interval'],
                ],
            ],
            'metadata' => [
                'provider_id' => $provider->id,
            ],
            'success_url' => route('billing.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('billing.cancel'),
        ]);

        return redirect($session->url);
    }

    /**
     * Create a Stripe Customer Portal session and redirect the provider admin there.
     *
     * GET /billing/portal
     */
    public function portal(Request $request): RedirectResponse
    {
        $this->boot();

        $provider = $request->user()->provider;

        if (!$provider?->stripe_customer_id) {
            return redirect()->route('billing.checkout')
                ->with('warning', 'No active Stripe subscription found. Please subscribe first.');
        }

        $session = PortalSession::create([
            'customer'   => $provider->stripe_customer_id,
            'return_url' => route('dashboard'),
        ]);

        return redirect($session->url);
    }

    /**
     * Post-checkout success landing page.
     */
    public function success(Request $request): View
    {
        return view('billing.success');
    }

    /**
     * Post-checkout cancellation landing page.
     */
    public function cancel(Request $request): View
    {
        return view('billing.cancel');
    }
}
