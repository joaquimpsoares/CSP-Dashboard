@extends('layouts.master')
@section('css')

@endsection

@section('content')
{{--
    <div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-6 sm:px-6 lg:max-w-full lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div>

                <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ ucwords(trans_choice('messages.customer', 2)) }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{$reseller->customers->count()}}
                        </dd>
                    </div>

                    <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ ucwords(trans_choice('messages.subscription', 2)) }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{$subscriptions->count()}}
                        </dd>
                    </div>

                    <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ ucwords(trans_choice('messages.order', 2)) }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{$reseller->orders}}
                        </dd>
                    </div>
                </dl>
            </div>
            <div
            x-data="{
                openTab: 1,
                activeClasses: 'bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5',
                inactiveClasses: 'bg-transparent absolute inset-x-0 bottom-0 h-0.5'
            }" >
            <div class=" sm:block">
                <nav class="relative z-0 flex divide-x divide-gray-200 rounded-lg shadow" aria-label="Tabs">
                    <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                    <a  @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" href="#" class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-900 bg-white rounded-l-lg group hover:bg-gray-50 focus:z-10" aria-current="page">
                        <span>{{ ucwords(trans_choice('messages.customer', 2)) }}</span>
                        <span aria-hidden="true" :class="openTab === 1 ? activeClasses : inactiveClasses"></span>
                    </a>
                    <a  @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" href="#" class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                        <span>{{ ucwords(trans_choice('messages.subscription', 2)) }}</span>
                        <span aria-hidden="true" :class="openTab === 2 ? activeClasses : inactiveClasses"></span>
                    </a>
                    <a @click="openTab = 3" :class="{ '-mb-px': openTab === 3 }" href="#" class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                        <span>{{ ucwords(trans_choice('messages.user', 2)) }}</span>
                        <span aria-hidden="true" :class="openTab === 3 ? activeClasses : inactiveClasses"></span>
                    </a>
                    <a @click="openTab = 4" :class="{ '-mb-px': openTab === 4 }" href="#" class="relative flex-1 min-w-0 px-4 py-4 overflow-hidden text-sm font-medium text-center text-gray-500 bg-white rounded-r-lg hover:text-gray-700 group hover:bg-gray-50 focus:z-10">
                        <span>Billing</span>
                        <span aria-hidden="true" :class="openTab === 4 ? activeClasses : inactiveClasses"></span>
                    </a>
                </nav>
            </div>
            <div x-show="openTab === 1">
                <section class="py-5" aria-labelledby="applicant-information-title">
                    <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                            <div class="mt-2 ml-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    {{ ucwords(trans_choice('messages.customer', 2)) }}
                                </h3>
                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                                    <div class="dropdown-menu">
                                        @if(Auth::user()->userLevel->id === 4)
                                        <a class="dropdown-item" href="{{route('customer.create')}}"><i class="mr-2 fa fa-plus"></i>{{ ucwords(__('messages.new_customer')) }}</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <div class="mb-0 ml-5 btn-group">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                            <div class="flex flex-col">
                                <div class="mb-5 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-5 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                            @include('customer.partials.table', ['customers' => $customers])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div x-show="openTab === 2">
                <section class="py-5" aria-labelledby="applicant-information-title">
                    <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                            <div class="mt-2 ml-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    {{ ucwords(trans_choice('messages.subscription', 2)) }}
                                </h3>
                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <div class="mb-0 ml-5 btn-group">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 border-t sm:px-6">
                            <div class="flex flex-col">
                                <div class="mb-5 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-5 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-b sm:rounded-lg">
                                            @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div x-show="openTab === 3">
                <section aria-labelledby="applicant-information-title">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                                <div class="mt-2 ml-4">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        {{ ucwords(trans_choice('messages.user', 2)) }}
                                    </h3>
                                </div>
                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <div class="mb-0 ml-5 btn-group">
                                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                                        <div class="dropdown-menu">
                                            @if (Route::current()->getName() === "user.index")
                                            <a class="dropdown-item" href="{{route('user.create', ['level' => 'provider', 'provider_id' ] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                            @endif
                                            @if (Route::current()->getName() === "reseller.show")
                                            <div>
                                                <a class="dropdown-item" href="{{route('user.create', ['level' => 'reseller', 'provider_id' => $reseller->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                            </div>
                                            @endif
                                            @if (Route::current()->getName() === "provider.show")
                                            <div>
                                                <a class="dropdown-item" href="{{route('user.create', ['level' => 'provider', 'provider_id' => $reseller->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                            <table id="example" class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.email', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($users as $user)
                                                    <tr>
                                                        <td><img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='30' Height ='auto'></td>
                                                        <td><a href="{{ route('user.edit', $user) }}">{{ $user['email'] }}</a></td>
                                                        <td>{{ $user['name'] }}</td>
                                                        <td>{{ $user['last_name'] }}</td>
                                                        <td>
                                                            @if($user->status->name == 'messages.active')
                                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                                {{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                                            </span>
                                                            @else
                                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                                                {{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                                            </span>
                                                            @endif
                                                            <td>
                                                                <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-white btn-svg" type="button" >Edit</a>
                                                                <a class="btn btn-sm btn-white btn-svg" type="button"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 9h8v10H8z" opacity=".3"/><path d="M15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z"/></svg></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div x-show="openTab === 4">
                </div>
            </div>

        </div>
        <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                        <div class="mt-2 ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ ucwords(trans_choice('messages.reseller_details', 1)) }}
                            </h3>
                        </div>
                        <div class="flex-shrink-0 mt-2 ml-4">
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $reseller->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                {{ ucwords(trans_choice($reseller->status->name, 1)) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-2 border-t border-gray-200 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.company_name', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->company_name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.nif', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->nif}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.country', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->country->name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.city', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->city}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.mpnid', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->mpnid}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.price_list', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->pricelist->name}}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    @canImpersonate
                    @if(!empty($reseller->format()['mainUser']))
                    <x-a color="blue" href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}"><i class="mt-0.5 mr-2 fa fa-user-secret"></i> {{ ucwords(trans_choice('messages.impersonate', 1)) }}</x-a>
                    @endif
                    @endCanImpersonate
                    <x-slideout :reseller="$reseller"></x-slideout>
                </div>
            </div>
            @if(!@empty($serviceCosts))
            <div class="mt-4 bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                        <div class="mt-2 ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ ucwords(trans_choice('messages.estimated_billing', 1)) }}
                            </h3>
                        </div>
                        <div class="flex-shrink-0 mt-2 ml-4">
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $reseller->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">

                            </p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 border-gray-200 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.billing_start_date', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ date('d-m-Y', strtotime($serviceCosts->billingStartDate))}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.billing_end_date', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{date('d-m-Y', strtotime($costs->billingEndDate))}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.pretax_total', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{number_format($costs->pretaxTotal, 2)}}{{$costs->currencySymbol}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.after_total', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{number_format($costs->afterTaxTotal, 2)}}{{$costs->currencySymbol}}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                </div>
                @endif
            </div>
        </section>
    </div> --}}

    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.reseller', 1)) }}</h4>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <span class="box-border">{{$reseller->company_name}}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reseller->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                            {{ ucwords(trans_choice($reseller->status->name, 1)) }}
                        </span>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block px-3 mt-6 text-left">
                            <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                    <span class="box-border">
                                        Actions
                                    </span>
                                </span>
                            </button>
                            <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="{{$reseller->format()['path']}}/edit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">{{ ucwords(trans_choice('messages.edit', 1)) }} </a>
                                </div>
                                <div class="py-1" role="none">
                                    @canImpersonate
                                    @if(!empty($reseller->format()['mainUser']))
                                    <a href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">Impersonate</a>
                                    @endif
                                    @endCanImpersonate
                                </div>
                                <div class="py-1" role="none">
                                    @if($reseller->status->name == 'messages.active')
                                    <a href="#" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">Disable</a>
                                    @endif
                                    @if($reseller->status->name != 'messages.active')
                                    <a href="#" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">Enable</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-32 p-0 px-4 py-2 m-0 border-r shadow-xs">
                <span class="font-bold">{{ ucwords(trans_choice('messages.subscription_started', 1)) }}</span>
                <div>
                    <span class="text-xs text-gray-500">{{ date('j F, Y', strtotime($reseller->created_at))}}</span>
                </div>
            </div>

            <div class="px-0 pt-0 mt-5 break-words border-b">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.reseller_details', 1)) }}</h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-flow-col grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-between mt-4 mb-4">
                        <div class="">
                            <dl>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$reseller->company_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($reseller->created_at))}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    {{-- <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt> --}}
                                    {{-- @if($customer->microsoftTenantInfo->first())
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <button value="copy" onclick="copyToClipboard('copy_{{ $customer->microsoftTenantInfo->first()->tenant_domain }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                                <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                                    <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                        <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                            <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                            </svg>
                                                        </div>
                                                        <span >
                                                            <input id="copy_{{ $customer->microsoftTenantInfo->first()->tenant_domain }}" value="{{ strtoupper($customer->microsoftTenantInfo->first()->tenant_domain) }}" class="inline w-48 mr-1 font-mono text-xs font-normal" />
                                                        </span>
                                                    </div>
                                                </div>
                                            </button>
                                        </dd>
                                        @endif --}}
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 col-start-2 row-start-1">
                        <div>
                            <div class="flex justify-between mt-4 mb-8">
                                <div class="">
                                    <dl>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.address', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($reseller->address_1)}}</dd>
                                        </div>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.city', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($reseller->city)}}</dd>
                                        </div>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.country', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($reseller->country->name)}}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-0 pt-0 mt-5 break-words border-b">
                    <div class="flex flex-col lg:flex-row">
                        <div class="flex items-center">
                            <h4>{{ ucwords(trans_choice('messages.provider_relationship', 1)) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="grid grid-flow-col grid-cols-2 gap-4">
                    <div>
                        <div class="flex justify-between mt-4 mb-8">
                            <div class="">
                                <dl>
                                    {{-- @dd($reseller->provider) --}}
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$reseller->provider->company_name}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.main_contact', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$reseller->provider->users->first()->name}} {{$reseller->provider->users->first()->last_name}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.phone', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$reseller->provider->users->first()->phone}}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-0 m-0 break-words">
                    <div class="px-0 pt-0 pb-5 m-0">
                        <div class="p-0 m-0 overflow-visible bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                            <div class="px-0 pt-0 mt-10 break-words border-b">
                                <div class="flex flex-col lg:flex-row">
                                    <div class="flex items-center">
                                        <h4>{{ ucwords(trans_choice('messages.customer', 2)) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-4 pb-5 m-0">
                                <table class="min-w-full px-4 divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.subscription', 2)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.license', 1)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.tenant', 2)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.cost', 1)) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reseller->customers as $key => $customers)
                                        @foreach($customers->subscriptions->groupby('customer_id') as $subscription)
                                        <tr  class="hover:bg-gray-100">
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline"href="{{$subscription->first()->customer->format()['path']}}">
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline font-medium text-gray-900">
                                                            @php
                                                            $subscription->map(function ($item) {
                                                                foreach ($item->customer as $customer) {
                                                                    $item['company_name'] = $item->customer->company_name;
                                                                }
                                                                return $item;
                                                            });
                                                            @endphp
                                                            {{$subscription->first()->company_name}}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline"href="{{$subscription->first()->customer->format()['path']}}">
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline font-medium text-gray-900">
                                                            {{$subscription->count()}}
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-2 py-2 text-sm font-medium text-center text-gray-900 whitespace-wrap lg:table-cell">
                                                <a  href="{{$subscription->first()->customer->format()['path']}}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline">
                                                    <span class="inline font-medium text-gray-900">
                                                        {{$subscription->sum('amount')}}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                                <span class="inline font-medium text-gray-900">
                                                    <input id="copy_{{ $subscription->first()->tenant_name }}" aria-invalid="false" readonly="" placeholder="" type="text" class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto w-76" value="{{$subscription->first()->tenant_name}}" />
                                                </span>
                                                <span class="inline font-medium text-gray-900">
                                                    <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->first()->tenant_name }}')" >
                                                        <div class="relative flex flex-row items-baseline w-full p-0 m-0">
                                                            <div class="flex-none p-0 m-0">
                                                            </div>
                                                            <div class="flex flex-row items-baseline justify-center flex-auto w-full p-0 m-0">
                                                                <div class="px-px py-0 m-0">
                                                                    <div aria-hidden="true" class="flex p-0 mx-0 mb-0 -mt-px text-gray-700">
                                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; font-variant: tabular-nums; line-height: 0px; overflow-wrap: break-word;">
                                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <span class="absolute block w-px h-px -mt-px overflow-hidden normal-case whitespace-no-wrap">
                                                                    <span class="box-border">Copy to clipboard</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </span>
                                            </td>

                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                <a  href="{{$subscription->first()->customer->format()['path']}}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline">
                                                    <span class="inline font-medium text-gray-900">
                                                        {{$subscription->first()->expiration_data}}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                <a  href="{{$subscription->first()->customer->format()['path']}}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline">
                                                    @php
                                                    $subscription->map(function ($item) use ($subscription){
                                                        if(isset($item->order)){
                                                            foreach ($item->order as $order) {
                                                                    $item['cost'] = ($order->orderproduct->retail_price*$subscription->first()->amount)*($subscription->first()->billing_period === 'annual' ? 12 : 1);
                                                            }
                                                            return $item;
                                                        }
                                                    });
                                                    @endphp
                                                    <span class="inline text-sm font-normal leading-5 text-gray-900">
                                                        @money($subscription->first()->cost) {{$subscription->first()->currency}} / {{$subscription->first()->billing_period}}

                                                        {{-- {{number_format(($subscription->order->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_p
                                                            eriod === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}} --}}
                                                    </span>

                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

