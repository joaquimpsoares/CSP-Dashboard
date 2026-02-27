<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    /**
     * Verify the Stripe signature and dispatch to the appropriate handler.
     *
     * Route: POST stripe/webhook (excluded from CSRF in VerifyCsrfToken).
     */
    public function handle(Request $request): Response
    {
        $secret = config('services.stripe.webhook_secret');

        if (!$secret) {
            Log::error('Stripe webhook received but services.stripe.webhook_secret is not set.');
            return response('Webhook not configured', 500);
        }

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook — invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::warning('Stripe webhook — invalid signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        Log::info('Stripe webhook received', ['type' => $event->type, 'id' => $event->id]);

        match ($event->type) {
            'checkout.session.completed'    => $this->handleCheckoutCompleted($event->data->object),
            'customer.subscription.created' => $this->handleSubscriptionSynced($event->data->object, 'created'),
            'customer.subscription.updated' => $this->handleSubscriptionSynced($event->data->object, 'updated'),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($event->data->object),
            'invoice.payment_failed'        => $this->handleInvoicePaymentFailed($event->data->object),
            default                         => null,
        };

        return response('ok', 200);
    }

    // -------------------------------------------------------------------------
    // Event handlers
    // -------------------------------------------------------------------------

    /**
     * Checkout Session completed: persist Stripe IDs on the provider and
     * activate the subscription.
     */
    private function handleCheckoutCompleted(\Stripe\Checkout\Session $session): void
    {
        $providerId = $session->metadata['provider_id'] ?? null;

        if (!$providerId) {
            Log::warning('checkout.session.completed — missing provider_id in metadata', [
                'session_id' => $session->id,
            ]);
            return;
        }

        $provider = Provider::find($providerId);

        if (!$provider) {
            Log::warning('checkout.session.completed — provider not found', [
                'provider_id' => $providerId,
            ]);
            return;
        }

        // Retrieve the full subscription so we can identify the metered item.
        Stripe::setApiKey(config('services.stripe.secret'));

        $subscription  = Subscription::retrieve([
            'id'     => $session->subscription,
            'expand' => ['items'],
        ]);

        $meteredItemId = $this->findMeteredItemId($subscription);
        $meta          = $subscription->metadata;

        $provider->update([
            'stripe_customer_id'          => $session->customer,
            'stripe_subscription_id'      => $session->subscription,
            'stripe_subscription_item_id' => $meteredItemId,
            'stripe_plan'                 => $meta['plan']     ?? null,
            'stripe_status'               => $subscription->status,
            'stripe_currency'             => $meta['currency'] ?? null,
            'stripe_interval'             => $meta['interval'] ?? null,
        ]);

        Log::info('checkout.session.completed — provider subscription activated', [
            'provider_id'     => $provider->id,
            'stripe_customer' => $session->customer,
            'plan'            => $meta['plan'] ?? null,
            'status'          => $subscription->status,
        ]);
    }

    /**
     * Subscription created or updated: keep the provider record in sync.
     */
    private function handleSubscriptionSynced(\Stripe\Subscription $subscription, string $event): void
    {
        $provider = Provider::where('stripe_customer_id', $subscription->customer)->first();

        if (!$provider) {
            // May arrive before checkout.session.completed on first creation — safe to ignore.
            Log::info("subscription.{$event} — no provider matched customer yet", [
                'customer' => $subscription->customer,
            ]);
            return;
        }

        $meteredItemId = $this->findMeteredItemId($subscription);
        $meta          = $subscription->metadata;
        $interval      = $subscription->items->data[0]->price->recurring->interval ?? null;

        $provider->update([
            'stripe_subscription_id'      => $subscription->id,
            'stripe_subscription_item_id' => $meteredItemId ?? $provider->stripe_subscription_item_id,
            'stripe_plan'                 => $meta['plan']  ?? $provider->stripe_plan,
            'stripe_status'               => $subscription->status,
            'stripe_interval'             => $interval      ?? $provider->stripe_interval,
        ]);

        Log::info("subscription.{$event} — provider synced", [
            'provider_id' => $provider->id,
            'status'      => $subscription->status,
            'plan'        => $meta['plan'] ?? $provider->stripe_plan,
        ]);
    }

    /**
     * Subscription deleted: mark the provider as canceled.
     */
    private function handleSubscriptionDeleted(\Stripe\Subscription $subscription): void
    {
        $provider = Provider::where('stripe_customer_id', $subscription->customer)->first();

        if (!$provider) {
            Log::warning('subscription.deleted — provider not found', [
                'customer' => $subscription->customer,
            ]);
            return;
        }

        $provider->update(['stripe_status' => 'canceled']);

        Log::info('subscription.deleted — provider marked canceled', [
            'provider_id' => $provider->id,
        ]);
    }

    /**
     * Payment failed: flip the provider to past_due so the UI can prompt renewal.
     */
    private function handleInvoicePaymentFailed(\Stripe\Invoice $invoice): void
    {
        $provider = Provider::where('stripe_customer_id', $invoice->customer)->first();

        if (!$provider) {
            Log::warning('invoice.payment_failed — provider not found', [
                'customer'   => $invoice->customer,
                'invoice_id' => $invoice->id,
            ]);
            return;
        }

        $provider->update(['stripe_status' => 'past_due']);

        Log::warning('invoice.payment_failed — provider marked past_due', [
            'provider_id' => $provider->id,
            'invoice_id'  => $invoice->id,
            'amount_due'  => $invoice->amount_due,
        ]);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Return the ID of the first metered SubscriptionItem, or null if none.
     */
    private function findMeteredItemId(\Stripe\Subscription $subscription): ?string
    {
        foreach ($subscription->items->data as $item) {
            if (($item->price->recurring->usage_type ?? null) === 'metered') {
                return $item->id;
            }
        }
        return null;
    }
}
