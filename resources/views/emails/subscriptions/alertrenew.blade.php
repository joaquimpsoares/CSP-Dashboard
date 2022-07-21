@component('mail::message')
<img width="100" src="{{asset($subscription->customer->resellers->first()->provider->logo)}}" alt="{{config('app.name')}}"><br>
@lang('mail.title_your_microsoft_subscriptions')


You have 1 expired subscriptions that will be disabled on **{{date('j F, Y', strtotime($subscription->expiration_data))}}**.
To avoid disruption, renew your subscriptions in **Tagydes Portal** by that date.

@component('mail::button', ['url' => $subscription->format()['path']])
Renew subscription
@endcomponent

Turn on recurring billing or work with your Microsoft partner **{{$subscription->customer->resellers->first()->company_name}}** to automatically renew your subscriptions in the future.

Subscription being disabled on **{{date('j F, Y', strtotime($subscription->expiration_data))}}**

@component('mail::table')
| Subscription           | Impacted licences          |
| ---------------------- |:--------------------------:|
| {{$subscription->name}}| {{$subscription->amount}}  |
@endcomponent

# Account information

**Company name:** {{$subscription->customer->company_name}}<br>
**Domain:** {{$subscription->customer->microsoftTenantInfo->first()->tenant_domain}}


Thank you,<br>
{{$subscription->customer->resellers->first()->company_name}}
@endcomponent
