@extends('layouts.master')
@section('css')
@endsection
@section('content')
@livewire('subscription.show-subscription', ['subscriptions' => $subscriptions], key($subscriptions->id))
@endsection
<script>
    function copyToClipboard(subscription_id) {
        document.getElementById(subscription_id).select();
        document.execCommand('copy');
        if(document.execCommand('copy')) {
            alert('Text Copied');
            document.body.removeChild(input);
        }
    }
</script>

