@extends('azureanalytics::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        <livewire:azureanalytics::azure.azure-table />
        {{-- <livewire:azureanalytics::azure.azure-table /> --}}
        {{-- @livewire('AzureAnalytics::azure.azure-table') --}}
        This view is loaded from module: {!! config('azureanalytics.name') !!}
    </p>
@endsection
