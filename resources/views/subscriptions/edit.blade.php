@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3">
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
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.licenses', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="flex justify-center w-1/5">
                                    <svg class="w-3 text-gray-600 fill-current" viewBox="0 0 448 512"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                                    </svg>

                                    <input class="w-10 mx-2 text-center border" type="text" value="{{ $subscriptions->amount }}">

                                    <svg class="w-3 text-gray-600 fill-current" viewBox="0 0 448 512">
                                      <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                                    </svg>
                                {{-- <input class="form-control" type="text" name="" value="{{ $subscriptions->amount }}"> --}}
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
                                                        {{ ucwords(trans_choice('messages.renew_subs_automatically', 1)) }}
                                                    </h3>
                                                    <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                                        <div class="max-w-xl text-sm text-white">
                                                            <p id="renew-description">
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo totam non cumque deserunt officiis ex maiores nostrum.
                                                            </p>
                                                        </div>
                                                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                                            <span class="mr-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                                                <span class="text-sm font-medium text-gray-900">Disable </span>
                                                              </span>
                                                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': on, 'bg-gray-200': !(on) }" aria-labelledby="renew-subscription-label" :aria-checked="on.toString()" @click="on = !on">
                                                                <span class="sr-only">Use setting</span>
                                                                <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                                            </button>
                                                            <span class="ml-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                                                <span class="text-sm font-medium text-gray-900">Enable </span>
                                                              </span>
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
                                                        {{ ucwords(trans_choice('messages.subscription_status', 1)) }}
                                                    </h3>
                                                    <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                                        <div class="max-w-xl text-sm text-white">
                                                            <p id="renew-description">
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo totam non cumque deserunt officiis ex maiores nostrum.
                                                            </p>
                                                        </div>
                                                        <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                                            <div class="flex items-center" x-data="{ on: true }">
                                                                <span class="mr-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                                                  <span class="text-sm font-medium text-gray-900">Disable </span>
                                                                </span>
                                                                <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': on, 'bg-gray-200': !(on) }" aria-labelledby="annual-billing-label" :aria-checked="on.toString()" @click="on = !on">
                                                                  <span class="sr-only">Use setting</span>
                                                                  <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                                                </button>
                                                                <span class="ml-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                                                    <span class="text-sm font-medium text-gray-900">Enabled </span>
                                                                  </span>
                                                              </div>
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
{{-- <div class="row">
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ ucwords(trans_choice('messages.subscription', 1)) }}</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                                @method('PATCH')
                                @csrf
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.subscription_name', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">{{ $subscriptions->name }}</td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.tenant_name', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">{{ $subscriptions->tenant_name }}</td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.owner', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">{{ $subscriptions->customer->resellers->first()->company_name }}</td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.licenses', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">
                                        <div class="control">
                                            @if ($subscriptions->status == "1")
                                            <input readonly="readonly" class="input is-warning" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @else
                                            <input  class="form-control" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">
                                        @if ($subscriptions->status == "1")
                                        <div  readonly="readonly">
                                            @else
                                            @endif
                                            <div  class="select is-info">
                                                <select name="billing_period" required="required" class="form-control SlectBox SumoUnder" id="{{ $subscriptions->products->first()->id }}">
                                                    <option value="monthly" {{ $subscriptions->billing_period == "monthly" ? "selected":"" }}> Monthly</option>
                                                    <option value="annual" {{ $subscriptions->billing_period == "annual" ? "selected":"" }}> Annual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-0 py-2">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.status', 1)) }} </span>
                                    </td>
                                    <td class="px-0 py-2">
                                        <div name="status" class="select is-info">
                                            @can('subscription_delete')
                                            <select name="status" class="form-control SlectBox SumoUnder">
                                                <option  value="1" {{ $subscriptions->status_id == "1" ? "selected":"" }}> Active</option>
                                                <option  value="2" {{ $subscriptions->status_id == "2" ? "selected":"" }}> Suspended</option>
                                            </select>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @can('subscription_edit')
                                <td><button type="submit" class="btn btn-primary" type="submit">Change</button></td>
                                @endcan
                                <td><button type="" class="btn btn-danger" type="submit">Cancel</button></td>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
