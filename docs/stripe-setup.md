# Stripe setup (LIVE) — CSP-Dashboard

_Last updated: 2026-02-25_

This document records the Stripe LIVE configuration and the resulting Product/Price IDs for the CSP plans.

> Note: Do **not** paste secrets (Stripe secret keys, webhook signing secrets) into Git.
> Store them in the server `.env` / secret manager only.

---

## 1) Public plan structure

Each plan is a Stripe **Product** with 3 Prices per currency:

- **Base monthly** (flat rate)
- **Base annual** (flat rate; annual discounted = 10× monthly = “2 months free”)
- **Usage monthly** (metered, per **active subscription**)

Currencies:
- EUR
- USD

---

## 2) Stripe Products and Price IDs (LIVE)

### Starter
- Product: `prod_U2qGZrhCPpHbET`

EUR:
- Base monthly: `price_1T4kZkLscCqGLLUxQf4Pmy5y`
- Base annual: `price_1T4kfQLscCqGLLUxDrb9xH2j`
- Usage monthly: `price_1T4kmXLscCqGLLUxhAEFoEfd`

USD:
- Base monthly: `price_1T4nCELscCqGLLUxCdI0WdLl`
- Base annual: `price_1T4nCGLscCqGLLUxOAE5OBNt`
- Usage monthly: `price_1T4nCHLscCqGLLUx91NqMJ9Y`

### Growth
- Product: `prod_U2r3EuvccabUSL`

EUR:
- Base monthly: `price_1T4lLPLscCqGLLUxoQke4fCz`
- Base annual: `price_1T4mP7LscCqGLLUxOhrlqclm`
- Usage monthly: `price_1T4lvDLscCqGLLUxHhJywu0w`

USD:
- Base monthly: `price_1T4nCNLscCqGLLUxduMGU9K9`
- Base annual: `price_1T4nCPLscCqGLLUxEIryQPPG`
- Usage monthly: `price_1T4nCRLscCqGLLUxzr32tkEG`

### Scale
- Product: `prod_U2syP1di6UGQjN`

EUR:
- Base monthly: `price_1T4nCULscCqGLLUxNFvIXKi6`
- Base annual: `price_1T4nCWLscCqGLLUxXR1TVTFY`
- Usage monthly: `price_1T4nCYLscCqGLLUxzzMWZ0NS`

USD:
- Base monthly: `price_1T4nCaLscCqGLLUxGAKLI9sn`
- Base annual: `price_1T4nCcLscCqGLLUxNnf6uu5i`
- Usage monthly: `price_1T4nCdLscCqGLLUx1qcdv09c`

---

## 3) `.env` variables to set on the server

```dotenv
# Stripe (LIVE)
STRIPE_SECRET_KEY=sk_live_***
STRIPE_WEBHOOK_SECRET=whsec_***

STRIPE_PRICE_STARTER_EUR_MONTHLY=price_1T4kZkLscCqGLLUxQf4Pmy5y
STRIPE_PRICE_STARTER_EUR_ANNUAL=price_1T4kfQLscCqGLLUxDrb9xH2j
STRIPE_PRICE_STARTER_EUR_USAGE=price_1T4kmXLscCqGLLUxhAEFoEfd
STRIPE_PRICE_STARTER_USD_MONTHLY=price_1T4nCELscCqGLLUxCdI0WdLl
STRIPE_PRICE_STARTER_USD_ANNUAL=price_1T4nCGLscCqGLLUxOAE5OBNt
STRIPE_PRICE_STARTER_USD_USAGE=price_1T4nCHLscCqGLLUx91NqMJ9Y

STRIPE_PRICE_GROWTH_EUR_MONTHLY=price_1T4lLPLscCqGLLUxoQke4fCz
STRIPE_PRICE_GROWTH_EUR_ANNUAL=price_1T4mP7LscCqGLLUxOhrlqclm
STRIPE_PRICE_GROWTH_EUR_USAGE=price_1T4lvDLscCqGLLUxHhJywu0w
STRIPE_PRICE_GROWTH_USD_MONTHLY=price_1T4nCNLscCqGLLUxduMGU9K9
STRIPE_PRICE_GROWTH_USD_ANNUAL=price_1T4nCPLscCqGLLUxEIryQPPG
STRIPE_PRICE_GROWTH_USD_USAGE=price_1T4nCRLscCqGLLUxzr32tkEG

STRIPE_PRICE_SCALE_EUR_MONTHLY=price_1T4nCULscCqGLLUxNFvIXKi6
STRIPE_PRICE_SCALE_EUR_ANNUAL=price_1T4nCWLscCqGLLUxXR1TVTFY
STRIPE_PRICE_SCALE_EUR_USAGE=price_1T4nCYLscCqGLLUxzzMWZ0NS
STRIPE_PRICE_SCALE_USD_MONTHLY=price_1T4nCaLscCqGLLUxGAKLI9sn
STRIPE_PRICE_SCALE_USD_ANNUAL=price_1T4nCcLscCqGLLUxNnf6uu5i
STRIPE_PRICE_SCALE_USD_USAGE=price_1T4nCdLscCqGLLUx1qcdv09c
```

---

## 4) Webhook endpoint (LIVE)

- URL: `https://dashboard.ontagydes.com/stripe/webhook`
- Endpoint ID: `we_1T4ni8LscCqGLLUxW1MOkIR3`
- Signing secret: **store in server env only** (`STRIPE_WEBHOOK_SECRET`)

Recommended events:
- `checkout.session.completed`
- `customer.subscription.created`
- `customer.subscription.updated`
- `customer.subscription.deleted`
- `invoice.created`
- `invoice.finalized`
- `invoice.paid`
- `invoice.payment_failed`
- `invoice.voided`

---

## 5) App code added (repo)

Webhook handler:
- `app/Http/Controllers/StripeWebhookController.php`

Route:
- `routes/web.php` → `POST stripe/webhook`

CSRF exclusion:
- `app/Http/Middleware/VerifyCsrfToken.php` → except `stripe/webhook`

---

## 6) Next implementation steps (not done yet)

- Persist Stripe customer/subscription IDs in DB.
- Implement Checkout Session creation for selected plan+currency+interval.
- Implement Customer Portal session.
- Implement usage reporting job:
  - compute active subscription count per billing tenant
  - post Usage Records for the metered subscription item.
- Add idempotency keys and webhook replay safety.
