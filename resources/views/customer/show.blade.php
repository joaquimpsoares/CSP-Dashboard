@extends('layouts.master')



@section('content')

<div class="min-h-screen bg-gray-100">
    <main class="py-10">
        <div class="max-w-2xl px-4 mx-auto sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
            <div class="flex items-center space-x-5">

            </div>
            <div class="flex flex-col-reverse mt-6 space-y-4 space-y-reverse justify-stretch sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                <div class="mt-4 text-lg-right mt-lg-0">
                    @canImpersonate
                    @if(!empty($customer->format()['mainUser']))
                    <a class="btn btn-white" href="{{ route('impersonate', $customer->format()['mainUser']['id']) }}"><i class="fa fa-user-secret"></i>{{ ucwords(trans_choice('messages.impersonate', 1)) }}</a>
                    @endif
                    @endCanImpersonate
                    {{-- <a href="{{$customer->format()['path']}}/edit" class="btn btn-primary">{{ ucwords(trans_choice('messages.edit_reseller', 1)) }} </a> --}}
                </div>
            </div>
        </div>
        <div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
            <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                <!-- Description list-->
                <div class="overflow-hidden bg-white shadow sm:rounded-md">
                    <div class="px-4 py-3 sm:px-6">
                        <h2 id="" class="text-lg font-medium leading-6 text-gray-900">
                            Subscriptions
                        </h2>
                        <p class="max-w-2xl text-sm text-gray-500">
                            Manage customer Subscription
                        </p>
                    </div>
                    <ul class="divide-gray-200 ">
                        @forelse($subscriptions as $key => $item)
                        <li>
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                        <a href="{{route('subscription.show', $item->id)}}" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="sr-only">Edit</span>
                                            <!-- Heroicon name: solid/pencil -->
                                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
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
                                    <div class="sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="text-sm font-medium"> Quantity:  </p>
                                            <p class="flex ml-1 text-gray-500 items-right text-xm">
                                                {{$item->amount}}
                                            </p>
                                        </div>
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
                        No Subscription yet
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
                                                        <td><img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'></td>
                                                        <td><a href="{{ route('user.edit', $user) }}">{{ $user['email'] }}</a></td>
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
                        {{-- <div>
                            <a href="#" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">Read full application</a>
                        </div> --}}
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
                            <div class="flex-shrink-0 mt-2 ml-4">
                                <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $customer->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                    {{ ucwords(trans_choice($customer->status->name, 1)) }}
                                </p>
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
                            {{-- <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    {{ ucwords(trans_choice('messages.tax_total', 1)) }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{number_format($costs->tax, 2)}}{{$costs->currencySymbol}}
                                </dd>
                            </div> --}}
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
                        {{-- <a href="{{$customer->format()['path']}}/edit" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">{{ ucwords(trans_choice('messages.edit_customer', 1)) }}</a> --}}
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
</div>



@endsection


