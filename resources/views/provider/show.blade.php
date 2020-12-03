@extends('layouts.master')
@section('css')

@endsection

@section('content')

@include('provider.partials.home', ['subscriptions' => $subscriptions])




<div class="row row-deck">
    <div class="col-xl-4 col-lg-5 col-md-12">
        @include('provider.partials.details')
    </div>

    <div class="col-xl-8 col-lg-7 col-md-12">
        @include('reseller.partials.table', ['resellers' => $resellers])
    </div>

</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    <div class="responsive">
        @include('customer.partials.table', ['customers' => $customers])
    </div>
</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    @include('user.partials.table', ['users' => $users] )
</div>

<div class="col-xl-12 co-llg-12 col-md-12">
    <div class="container col-xm-12">
        @include('packages.cards')
    </div>
</div>




@endsection


