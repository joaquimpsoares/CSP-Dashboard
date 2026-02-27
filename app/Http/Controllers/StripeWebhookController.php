<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    /**
     * Handle incoming Stripe webhooks.
     *
     * Route must be excluded from CSRF verification.
     */
    public function handle(Request $request): Response
    {
        $secret = env('STRIPE_WEBHOOK_SECRET');
        if (!$secret) {
            Log::error('Stripe webhook received but STRIPE_WEBHOOK_SECRET is not set');
            return response('Webhook not configured', 500);
        }

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            // Verify signature + parse event
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::warning('Stripe webhook invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::warning('Stripe webhook invalid signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        } catch (\Throwable $e) {
            Log::error('Stripe webhook error', ['error' => $e->getMessage()]);
            return response('Webhook error', 400);
        }

        $type = $event->type ?? 'unknown';
        $id = $event->id ?? null;

        // Minimal processing for now: log receipt.
        // TODO: persist subscription status/customer ids to DB tables.
        Log::info('Stripe webhook received', [
            'type' => $type,
            'id' => $id,
            'livemode' => $event->livemode ?? null,
        ]);

        return response('ok', 200);
    }
}
