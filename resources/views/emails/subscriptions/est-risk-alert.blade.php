@component('mail::message')
# Action Required: Subscriptions at EST Risk

Hi {{ $provider->company_name ?? $provider->name ?? 'Partner' }},

**{{ $subscriptions->count() }} subscription(s)** in your **{{ strtoupper($environment) }}** environment are at risk of being automatically enrolled in Microsoft's **Extended Service Term (EST)** on **April 1, 2026**.

EST auto-enrollment applies to NCE subscriptions where:
- Auto-renew is **disabled**
- The commitment end date falls **before April 1, 2026**

Affected subscriptions will be renewed at the **monthly rate + 3% uplift**.

@component('mail::table')
| Customer | Subscription | Expiry Date | Status |
|:---------|:-------------|:------------|:-------|
@foreach($subscriptions as $sub)
| {{ $sub->customer->company_name ?? $sub->customer_id }} | {{ $sub->name ?? 'N/A' }} | {{ $sub->expiration_data ? \Carbon\Carbon::parse($sub->expiration_data)->format('M d, Y') : '—' }} | {{ $sub->status_id == 1 ? 'ACTIVE' : 'INACTIVE' }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => config('app.url') . '/subscriptions', 'color' => 'red'])
Review At-Risk Subscriptions
@endcomponent

**To prevent EST enrollment**, log in and enable auto-renew or cancel the subscription before April 1, 2026.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
