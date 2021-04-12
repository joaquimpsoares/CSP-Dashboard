@extends('layouts.master')



@section('content')

<div class="max-w-2xl px-4 mx-auto sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-full lg:px-8">
    <div class="flex items-center space-x-5">
    </div>
</div>
<div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-6 sm:px-6 lg:max-w-full lg:grid-flow-col-dense lg:grid-cols-3">
    <div class="space-y-6 lg:col-start-1 lg:col-span-2">
        <!-- Description list-->
        <div class="overflow-hidden bg-white shadow sm:rounded-md">
            <div class="px-4 py-3 sm:px-6">
                <h2 id="" class="text-lg font-medium leading-6 text-gray-900">
                    {{ ucwords(trans_choice('subscription', 2)) }}
                </h2>
                <p class="max-w-2xl text-sm text-gray-500">
                    Manage customer Subscription
                </p>
            </div>
            @forelse($subscriptions as $key => $item)
            <ul class="border-t divide-gray-200 ">
                <li>
                    <a href="{{route('subscription.show', $item->id)}}" class="block hover:bg-gray-50">
                        <div class="px-4 py-1 sm:px-8">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{$item->name}}
                                </p>
                                <div class="flex flex-shrink-0 ml-2">
                                    <p class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
                                        {{ ucwords($item->billing_period) }}
                                    </p>
                                    <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $item->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                        {{ ucwords(trans_choice($item->status->name, 1)) }}
                                    </p>
                                </div>
                            </div>
                            <div class="-mt-4 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex text-xs text-gray-500 items-right">
                                        {{$item->subscription_id}}
                                    </p>
                                </div>
                            </div>
                            <div class="sm:flex sm:justify-between">
                                @if($item->billing_type == 'license')
                                <div class="sm:flex">
                                    <p class="text-sm font-medium"> {{ ucwords(trans_choice('quantity', 1)) }}  </p>
                                    <p class="flex ml-1 text-gray-500 items-right text-xm">
                                        {{$item->amount}}
                                    </p>
                                </div>
                                @else
                                <div class="sm:flex">
                                </div>
                                @endif
                                <div class="sm:flex">
                                    <p class="text-sm font-medium"> Expires On:  </p>
                                    <p class="flex ml-1 text-gray-500 items-right text-xm">
                                        <time datetime="2020-01-07">{{$item->expiration_data}}</time>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                <div class="flex flex-col justify-center py-3 sm:px-6 lg:px-8">
                    <div class="sm:mx-auto sm:w-full sm:max-w-md">
                        <h4 class="mt-6 text-center text-gray-600">
                            No subscriptions yet
                        </h4>
                        <h1 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                            <a href="{{route('store.store')}}" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.go_to_store', 1)) }}
                            </a>
                        </h2>
                    </div>
                </div>
                @endforelse
            </ul>
        </div>
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
                                    <a class="dropdown-item" href="{{route('user.create', ['level' => 'provider', 'customer_id' ] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                    @endif
                                    @if (Route::current()->getName() === "reseller.show")
                                    <div>
                                        <a class="dropdown-item" href="{{route('user.create', ['level' => 'reseller', 'customer_id' => $reseller->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                    </div>
                                    @endif
                                    @if (Route::current()->getName() === "customer.show")
                                    <div>
                                        <a class="dropdown-item" href="{{route('user.create', ['level' => 'customer', 'customer_id' => $customer->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
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
                                    <table class="min-w-full divide-y divide-gray-200">
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
                                                <td>
                                                    <img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='40' Height ='auto'></td>
                                                    <td>
                                                        <a href="{{ route('user.edit', $user) }}">{{ $user['email'] }}</a>
                                                    </td>
                                                    <td>{{ $user['name'] }}</td>
                                                    <td>{{ $user['last_name'] }}</td>
                                                    <td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
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
        <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                        <div class="mt-2 ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ ucwords(trans_choice('messages.customer_details', 1)) }}
                            </h3>
                        </div>
                        @canImpersonate
                        @if(!empty($customer->format()['mainUser']))
                        <a href="{{ route('impersonate', $customer->format()['mainUser']['id']) }}" type="button"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fa fa-user-secret"></i>{{ ucwords(trans_choice('messages.impersonate', 1)) }}
                        </a>
                        @endif
                        @endCanImpersonate
                        <div class="flex-shrink-0 mt-2 ml-4">
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $customer->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                {{ ucwords(trans_choice($customer->status->name, 1)) }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="sm:col-span-1">
                            <dd class="text-xs text-gray-500">
                                {{$customer->subscriptions->first()->tenant_name }}
                            </dd>
                            <dd class="text-xs text-gray-500">
                                {{$customer->microsoftTenantInfo->first()->tenant_id }}
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.company_name', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$customer->company_name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.nif', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$customer->nif}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.country', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$customer->country->name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.city', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$customer->city}}
                            </dd>
                        </div>
                    </dl>
                    <div class="border-t sm:col-span-1">
                        <dt class="mt-3 text-sm font-medium text-gray-500">
                            {{ ucwords(trans_choice('messages.markup', 1)) }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{$customer->markup}} %
                        </dd>
                    </div>
                </div>
                <div>
                    <a href="{{$customer->format()['path']}}/edit" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">{{ ucwords(trans_choice('messages.edit_customer', 1)) }}</a>
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
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $customer->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
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
                @endif
            </div>
        </section>
    </div>
</div>

@endsection


