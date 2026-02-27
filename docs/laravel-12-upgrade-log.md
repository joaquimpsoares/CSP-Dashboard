# Laravel 12 / PHP 8.4 upgrade log (CSP-Dashboard)

_Last updated: 2026-02-25_

This document records the actions taken to move CSP-Dashboard toward compatibility with **PHP 8.4** by upgrading to **Laravel 12**, and the consequences/tradeoffs.

> Goal: run CSP-Dashboard under PHP 8.4 (current host PHP: 8.4.17).

---

## Summary of current state

- **Laravel** upgraded and boots:
  - `php artisan --version` → `Laravel Framework 12.53.0`
- `vendor/` is present and dependencies resolved.
- Some legacy packages were removed to satisfy Laravel 12 compatibility.
- Authentication scaffolding is currently in transition (laravel/ui removed; Breeze planned).

---

## Key actions taken

### A) Composer / platform changes
- `composer.json` updated to target:
  - `php: ^8.4`
  - `laravel/framework: ^12.0`
- Introduced/updated modern packages:
  - `laravel/breeze` (planned to install)
  - `laravel/sanctum: ^4.0`
  - `livewire/livewire: ^3.0` (kept as future option)
  - `spatie/laravel-permission: ^6.0`
  - `stripe/stripe-php` bumped (for modern Stripe)
  - dev tools bumped (collision/ignition/phpunit) during resolution

### B) Removed packages (blocking Laravel 12)
Removed/disabled due to PHP 8.4 / Laravel 12 incompatibility or conflict:
- `tagydes/microsoft-connection` (private GitLab VCS dependency)
  - reason: blocked composer on this host (SSH host key / auth)
  - future replacement: Microsoft Graph integration via internal interface + maintained SDK
- `jamesmills/laravel-timezone` (Laravel <=10)
- `soved/laravel-gdpr` (carbon/dependency conflicts)
- `alajusticia/laravel-expirable` (carbon constraints)
- `fruitcake/laravel-cors` (obsolete; Laravel provides built-in CORS middleware)
- `laravelcollective/html` (legacy)
- `spatie/simple-excel` (legacy constraint chain)
- `romanzipp/laravel-queue-monitor` (removed; route macro disappeared)
- `hwi/oauth-bundle` (Symfony bundle; incompatible)

### C) Route fixes required after removals
- Removed/disabled `Route::queueMonitor()` usage from `routes/web.php`.
- Removed/disabled `Auth::routes()` from:
  - `routes/web.php`
  - `routes/tenant.php`
  Reason: `Auth::routes()` requires `laravel/ui`, which was removed in favor of Breeze.

---

## Consequences / follow-ups

### 1) Authentication
- **Current**: app will not rely on `Auth::routes()`.
- **Next**: install and configure **Laravel Breeze** and adapt existing login flows.

### 2) Microsoft connection
- The old microsoft-connection is removed.
- Planned architecture:
  - define `App\Contracts\MicrosoftGraphClient` (or similar)
  - implement with Microsoft Graph SDK or OAuth2 client
  - keep credentials in `.env`

### 3) Spreadsheet / GD
- Composer updates were run with `--ignore-platform-req=ext-gd`.
- For production use of PhpSpreadsheet, ensure `php8.4-gd` is installed.

### 4) Monitoring
- Queue monitor routes were removed.
- Future replacement options:
  - Horizon dashboards
  - custom queue monitoring UI

---

## Git / branch
- Work was performed on branch: `laravel-12-upgrade`

---

## Stripe work (related docs)
See:
- `docs/stripe-setup.md`

