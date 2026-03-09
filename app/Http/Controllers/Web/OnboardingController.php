<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class OnboardingController extends Controller
{
    // ── Step 1: Email OTP ────────────────────────────────────────────────

    public function showVerify()
    {
        $user = Auth::user();
        if ($user->onboarding_step >= 1) {
            return redirect()->route('onboarding.type');
        }
        return view('onboarding.verify-email');
    }

    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        // Rate limit: no resend within 60 seconds (otp_expires_at is set for 5 min; block if >4 min remain)
        if ($user->otp_expires_at && now()->lt($user->otp_expires_at->subSeconds(240))) {
            return back()->withErrors(['otp' => 'Please wait before requesting a new code.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'otp_code'       => bcrypt($code),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        Mail::to($user->email)->send(new \App\Mail\OnboardingOtpMail($user, $code));

        return back()->with('otp_sent', true);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);
        $user = Auth::user();

        if (! $user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Code expired. Please request a new one.']);
        }

        if (! password_verify($request->otp, $user->otp_code)) {
            return back()->withErrors(['otp' => 'Invalid code. Please try again.']);
        }

        $user->forceFill([
            'otp_code'        => null,
            'otp_expires_at'  => null,
            'onboarding_step' => 1,
        ])->save();

        return redirect()->route('onboarding.type');
    }

    // ── Step 2: Partner type ─────────────────────────────────────────────

    public function showType()
    {
        $user = Auth::user();
        if ($user->onboarding_step < 1) {
            return redirect()->route('onboarding.verify');
        }
        if ($user->onboarding_step >= 2) {
            return redirect()->route('onboarding.plan');
        }
        return view('onboarding.partner-type');
    }

    public function saveType(Request $request)
    {
        $request->validate(['type' => 'required|in:direct,indirect']);

        $user = Auth::user();

        if ($user->provider) {
            $user->provider->forceFill(['type' => $request->type])->save();
        }

        $user->forceFill(['onboarding_step' => 2])->save();

        return redirect()->route('onboarding.plan');
    }

    // ── Step 3: Stripe plan selection ────────────────────────────────────

    public function showPlan()
    {
        $user = Auth::user();
        if ($user->onboarding_step < 2) {
            return redirect()->route('onboarding.type');
        }
        if ($user->onboarding_step >= 3) {
            return redirect()->route('dashboard');
        }

        $plans = [
            'starter' => [
                'name'        => 'Starter',
                'description' => 'For small CSP partners getting started',
                'features'    => ['Up to 50 customers', 'Sandbox environment', 'Email support'],
                'prices'      => $this->getPrices('starter'),
            ],
            'growth' => [
                'name'        => 'Growth',
                'description' => 'For growing indirect providers and resellers',
                'features'    => ['Up to 500 customers', 'Sandbox + Live', 'Priority support', 'EST Guard'],
                'prices'      => $this->getPrices('growth'),
            ],
            'scale' => [
                'name'        => 'Scale',
                'description' => 'For large providers managing multiple resellers',
                'features'    => ['Unlimited customers', 'All environments', 'Dedicated support', 'All features'],
                'prices'      => $this->getPrices('scale'),
            ],
        ];

        return view('onboarding.plan-selection', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'plan'     => 'required|in:starter,growth,scale',
            'currency' => 'required|in:eur,usd',
            'interval' => 'required|in:monthly,annual,usage',
        ]);

        $user     = Auth::user();
        $provider = $user->provider;

        $priceKey = 'STRIPE_PRICE_' .
            strtoupper($request->plan) . '_' .
            strtoupper($request->currency) . '_' .
            strtoupper($request->interval);

        $priceId = env($priceKey);

        if (! $priceId) {
            return back()->withErrors(['plan' => 'Selected plan is not available.']);
        }

        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        // Create or retrieve Stripe customer
        if (! $provider->stripe_customer_id) {
            $customer = $stripe->customers->create([
                'email'    => $user->email,
                'name'     => $provider->company_name,
                'metadata' => ['provider_id' => $provider->id],
            ]);
            $provider->forceFill(['stripe_customer_id' => $customer->id])->save();
        }

        // Create subscription with 14-day trial
        $subscription = $stripe->subscriptions->create([
            'customer'          => $provider->stripe_customer_id,
            'items'             => [['price' => $priceId]],
            'trial_period_days' => 14,
            'payment_behavior'  => 'default_incomplete',
            'payment_settings'  => ['save_default_payment_method' => 'on_subscription'],
            'expand'            => ['latest_invoice.payment_intent'],
            'metadata'          => [
                'provider_id' => $provider->id,
                'plan'        => $request->plan,
            ],
        ]);

        $provider->forceFill([
            'stripe_subscription_id' => $subscription->id,
            'stripe_plan'            => $request->plan,
            'stripe_status'          => $subscription->status,
            'stripe_currency'        => $request->currency,
            'stripe_interval'        => $request->interval,
            'trial_ends_at'          => now()->addDays(14),
        ])->save();

        $user->forceFill(['onboarding_step' => 3])->save();

        return redirect()->route('onboarding.complete');
    }

    public function complete()
    {
        $user = Auth::user();
        if ($user->onboarding_step < 3) {
            return redirect()->route('onboarding.verify');
        }
        return view('onboarding.complete');
    }

    // ── Helper ───────────────────────────────────────────────────────────

    private function getPrices(string $plan): array
    {
        $currencies = ['eur', 'usd'];
        $intervals  = ['monthly', 'annual', 'usage'];
        $prices     = [];

        foreach ($currencies as $currency) {
            foreach ($intervals as $interval) {
                $key = 'STRIPE_PRICE_' .
                    strtoupper($plan) . '_' .
                    strtoupper($currency) . '_' .
                    strtoupper($interval);
                $prices[$currency][$interval] = env($key);
            }
        }

        return $prices;
    }
}
