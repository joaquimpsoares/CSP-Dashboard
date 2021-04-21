@extends('layouts.master')
@section('css')
<!-- Data table css -->
{{-- <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" /> --}}
@endsection

@section('content')


<div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
    <div class="space-y-6 lg:col-start-1 lg:col-span-2">
        <section aria-labelledby="applicant-information-title">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                        {{ ucwords(trans_choice('messages.subscription', 1)) }}
                    </h2>
                </div>
                <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.subscription_name', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $subscriptions->name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.subscription_id', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $subscriptions->subscription_id }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.tenant', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $subscriptions->tenant_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.description', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $subscriptions->products->first()->description }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">
                                Manage Subscritpion
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <ul class="border-gray-200 divide-y divide-gray-200 rounded-md">
                                    <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                        <div class="max-w-3xl mx-auto">
                                            <div class="bg-white border shadow sm:rounded-lg">
                                                <div class="px-4 py-5 sm:p-6" x-data="{ on: true }">
                                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="renew-subscription-label">
                                                        Renew subscription automatically
                                                    </h3>
                                                    <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                                        <div class="max-w-xl text-sm text-gray-500">
                                                            <p id="renew-description">
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo totam non cumque deserunt officiis ex maiores nostrum.
                                                            </p>
                                                        </div>
                                                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': on, 'bg-gray-200': !(on) }" aria-labelledby="renew-subscription-label" :aria-checked="on.toString()" @click="on = !on">
                                                                <span class="sr-only">Use setting</span>
                                                                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm ">
                                        <div class="max-w-3xl mx-auto">
                                            <div class="bg-white border shadow sm:rounded-lg">
                                                <div class="px-4 py-5 sm:p-6" x-data="{ on: true }">
                                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="renew-subscription-label">
                                                        Subscription Status
                                                    </h3>
                                                    <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                                        <div class="max-w-xl text-sm text-gray-500">
                                                            <p id="renew-description">
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo totam non cumque deserunt officiis ex maiores nostrum.
                                                            </p>
                                                        </div>
                                                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': on, 'bg-gray-200': !(on) }" aria-labelledby="renew-subscription-label" :aria-checked="on.toString()" @click="on = !on">
                                                                <span class="sr-only">Use setting</span>
                                                                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    </div>

    <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
        <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
            <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Timeline</h2>
            <div class="flow-root mt-6">
                <ul class="-mb-8">
                    @foreach ($subscriptions->customer->orders as $item)
                    <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full ring-8 ring-white">
                                        <!-- Heroicon name: solid/user -->
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Applied to <a href="#" class="font-medium text-gray-900">{{$item->details}}</a></p>
                                    </div>
                                    <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                        <time datetime="2020-09-20">{{$item->created_at}}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if($item->order_status_id == 4)
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full ring-8 ring-white">
                                        <!-- Heroicon name: solid/check -->
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Order placed by: <a href="#" class="font-medium text-gray-900">{{$item->user->name}}</a></p>
                                    </div>
                                    <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                        <time datetime="2020-10-04">Oct 4</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</div>
{{-- </main>
</div>
<div class="container col-xm-12">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="view overlay">
                    <div class="card-body">
                        <div class="panel-block">
                            <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="field-group">
                                    <div class="field is-inline-block-desktop">
                                        <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h3>
                                        <div class="control">
                                            <input readonly="readonly"  name="name" type="text" placeholder="Text input" value="{{ $subscriptions->name }}">
                                        </div>
                                        <hr>
                                        <div class="field is-inline-block-desktop">
                                            <h3 class="card-title"><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p></h3>
                                            {{ $subscriptions->tenant_name }}</p>
                                        </div>
                                    </div>
                                    @foreach ($products as $product)
                                    @if ($product['billing'] == "license")
                                    <hr>
                                    <div class="field is-inline-block-desktop">
                                        {{ ucwords(trans_choice('messages.licenses', 1)) }}
                                        <div class="control">
                                            @if ($subscriptions->status == "1")
                                            <input readonly="readonly" class="input is-warning" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @else
                                            <input  class="input" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="control">
                                            <label for="nights" class="label is-small"> {{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</label>
                                            @if ($subscriptions->status == "1")
                                            <div  readonly="readonly">
                                                @else
                                                @endif
                                                <div  class="select is-info">
                                                    <select name="billing_period" >
                                                        <option value="monthly" {{ $subscriptions->billing_period == "monthly" ? "selected":"" }}> Monthly</option>
                                                        <option value="annual" {{ $subscriptions->billing_period == "annual" ? "selected":"" }}> Annual</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="control">
                                                <label for="nights" class="label is-small">Subscription Status</label>
                                                <div name="status" class="select is-info">
                                                    <select name="status">
                                                        <option  value="1" {{ $subscriptions->status_id == "1" ? "selected":"" }}> Active</option>
                                                        <option  value="2" {{ $subscriptions->status_id == "2" ? "selected":"" }}> Suspended</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="control">
                                    <div class="text-center text-md-left">
                                        <a data-toggle="modal" data-target="#centralModalInfo" class="genric-btn primary-brand">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                                        <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                        aria-hidden="true" data-backdrop="false">
                                        <div class="modal-dialog modal-notify modal-info" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <p class="heading lead">Update Subscription</p>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true" class="white-text">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <i class="mb-3 fas fa-check fa-4x animated rotateIn"></i>
                                                        <p>You are about to update Subscription {{$subscriptions->name}}</p>
                                                        <p>Are you sure?</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button  type="submit" type="button" class="genric-btn info waves-effect" >yes </button>
                                                    <a type="button" class="genric-btn danger waves-effect" data-dismiss="modal">No, thanks</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ URL::previous() }}">
                                        <span class="genric-btn danger" id="update-details-btn">
                                            {{ ucwords(trans_choice('messages.cancel', 1)) }}
                                        </span>
                                    </a>

                                    <a href="{{route('analytics.list')}}">
                                        <span class="genric-btn info" id="update-details-btn">
                                            {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                        </span></a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


@endsection

@section('scripts')


@endsection
