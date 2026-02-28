# MicrosoftCspConnection Module

Replacement for the removed `Tagydes\MicrosoftConnection` package.
Provides OAuth2 authentication and Partner Center REST API integration for
Microsoft CSP (Cloud Solution Provider) partners using the official
`microsoft/microsoft-graph` PHP SDK (v1.x) and Guzzle.

---

## Architecture

```
MicrosoftCspConnection (DB record, per-provider)
    └── MicrosoftCspClient       — OAuth2 token acquisition + Partner Center HTTP calls
          ├── CustomerService    — /v1/customers
          ├── SubscriptionService— /v1/customers/{id}/subscriptions
          ├── OfferService       — /v1/offers
          └── OrderService       — /v1/customers/{id}/carts + checkout
MicrosoftCspResolver             — Loads the right connection for a Provider
```

---

## Database Setup

Run `php artisan migrate` to create the `microsoft_csp_connections` table.

Each `Provider` (CSP partner) has **one connection record** per tenant:

| Column | Description |
|---|---|
| `provider_id` | FK to `providers` |
| `tenant_id` | Azure AD tenant ID of the partner account |
| `token_mode` | `app_only` or `sam` |
| `client_id` | App registration Client ID |
| `client_secret` | App registration Client Secret (**encrypted**) |
| `refresh_token` | SAM refresh token (**encrypted**, SAM mode only) |
| `partner_id` | Microsoft Partner Network (MPN) ID |
| `api_url` | Override API base URL (leave null for production) |
| `consented_at` | When the partner consented to the app |
| `mfa_compliant` | Last MFA compliance result (SAM mode) |
| `mfa_checked_at` | When MFA compliance was last checked |

### Seeding a test connection (local dev)

```php
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;

MicrosoftCspConnection::create([
    'provider_id'   => 1,
    'tenant_id'     => 'your-azure-ad-tenant-id',
    'token_mode'    => 'app_only',
    'client_id'     => 'your-app-client-id',
    'client_secret' => 'your-app-client-secret',
    'partner_id'    => 'your-mpn-id',
]);
```

---

## Token Modes

### `app_only` (Client Credentials)

For automated / server-to-server access. Requires:
- `tenant_id`
- `client_id`
- `client_secret`

The app registration must have **Partner Center API** permissions granted in Azure AD.

### `sam` (Secure Application Model)

For delegated access using a long-lived refresh token obtained via the
[SAM consent flow](https://docs.microsoft.com/en-us/partner-center/develop/enable-secure-app-model).
Requires:
- `tenant_id`
- `client_id`
- `client_secret`
- `refresh_token` — obtained once via the authorization_code flow; stored encrypted

In SAM mode, each API call includes the `ValidateMfa: true` header. The
`isMfaCompliant` response header is automatically saved back to the connection record.

---

## Separate Token Audiences

| Audience | Resource URL | Used for |
|---|---|---|
| Partner Center | `https://api.partnercenter.microsoft.com` | All CSP API calls |
| Microsoft Graph | `https://graph.microsoft.com` | Azure AD lookups, tenant info |

Tokens are cached separately per `(provider_id, tenant_id, token_mode, audience)`.

---

## Optional `.env` Override

```env
# Override the Partner Center API base URL (e.g. for sandbox testing)
CSP_API_URL=https://api.partnercenter.microsoft.com
```

All other credentials are stored in the database — **never** put tenant
secrets in `.env` in a multi-partner SaaS environment.

---

## Usage in Jobs / Services

```php
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\CustomerService;

// Load connection for provider
$connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
$client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));

// Use domain services
$customerService = new CustomerService($client);
$customers       = $customerService->list();
```

Or via the `MicrosoftCspResolver` singleton (registered in the ServiceProvider):

```php
use Modules\MicrosoftCspConnection\Services\MicrosoftCspResolver;

$client = app(MicrosoftCspResolver::class)->forProvider($provider);
```

---

## Connection Status

Visit `/microsoft-csp` (auth required) to see the connection status for your provider.
Visit `/microsoft-csp/test` to attempt a live token acquisition and verify credentials.

---

## Partner Center API Reference

- Base URL: `https://api.partnercenter.microsoft.com/v1/`
- [Customer resource](https://docs.microsoft.com/en-us/partner-center/develop/customer-resources)
- [Subscription resource](https://docs.microsoft.com/en-us/partner-center/develop/subscription-resources)
- [Order resource](https://docs.microsoft.com/en-us/partner-center/develop/order-resources)
- [Offer resource](https://docs.microsoft.com/en-us/partner-center/develop/offer-resources)
