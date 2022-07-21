@component('mail::message')
#  Renew your Microsoft Instance to avoid disruption

You have 1 expired Instance that needs to be renewed on **{{date("Y-m-d", strtotime($instance->external_token_updated_at->modify('+90 days')))}}**.
To avoid disruption, renew your Instance in **Tagydes Portal** by that date.

@component('mail::button', ['url' => 'instances/'.$instance->id.'/edit'])
Instance
@endcomponent

# Account information

**Company name:** {{$instance->provider->company_name}}<br>
**Instance:** {{$instance->name}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
