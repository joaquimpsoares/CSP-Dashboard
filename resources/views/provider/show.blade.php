@extends('layouts.master')


@section('content')

@livewire('provider.show-provider', ['provider' => $provider])

{{-- <div class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-6 sm:px-6 lg:max-w-full lg:grid-flow-col-dense lg:grid-cols-3">
    <div class="space-y-6 lg:col-start-1 lg:col-span-2">
        <!-- Description list-->
        <div class="overflow-hidden bg-white shadow sm:rounded-md">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="px-4 py-5 bg-white border-gray-200 sm:px-6">
                <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
                    <div class="mt-4 ml-4">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                    {{ ucwords(trans_choice('instance', 2)) }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ ucwords(trans_choice('Manage provider instance', 2)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-shrink-0 mt-4 ml-4">
                        <a href="{{route('instances.create', ['provider' => $provider->id])}}" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <!-- Heroicon name: solid/phone -->
                            <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            <span>
                                {{ ucwords(trans_choice('messages.add_new_instance', 2)) }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <ul class="divide-gray-200 ">
                @forelse($provider->instances as $item)
                <li>
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                <a href="{{route('instances.edit', $item->id)}}" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                    <span class="sr-only">{{ ucwords(trans_choice('messages.edit', 1)) }}</span>
                                    <!-- Heroicon name: solid/pencil -->
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <a href="{{route('instances.edit', $item->id)}}" class="block hover:bg-gray-50">
                        <div class="px-4 py-1 sm:px-8">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{$item->name}}
                                </p>
                                <div class="flex flex-shrink-0 ml-2">
                                    <p class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full">
                                        {{ $item->external_type }}
                                    </p>
                                </div>
                            </div>
                            <div class="sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="text-sm font-medium"> {{ ucwords(trans_choice('messages.isv', 1)) }}  </p>
                                    <p class="flex ml-1 text-gray-500 items-right text-xm">
                                        {{$item->type}}
                                    </p>
                                </div>
                                <div class="sm:flex">
                                    <p class="text-sm font-medium"> Expires On:  </p>
                                    <p class="flex ml-1 text-gray-500 items-right text-xm">
                                        @if($item->external_token_updated_at)
                                        <time datetime="2020-01-07">{{$item->external_token_updated_at->addDays(90)}}</time>
                                        @endif
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
                            {{ ucwords(trans_choice('messages.no_instance', 1)) }}
                        </h4>
                        <h1 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                            <a href="{{route('instances.create', ['provider' => $provider->id])}}" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <!-- Heroicon name: solid/phone -->
                                <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>
                                    {{ ucwords(trans_choice('messages.add_new_instance', 2)) }}
                                </span>
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
                                    <a class="dropdown-item" href="{{route('user.create', ['level' => 'provider', 'provider_id' ] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                    @endif
                                    @if (Route::current()->getName() === "reseller.show")
                                    <div>
                                        <a class="dropdown-item" href="{{route('user.create', ['level' => 'reseller', 'provider_id' => $reseller->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
                                    </div>
                                    @endif
                                    @if (Route::current()->getName() === "provider.show")
                                    <div>
                                        <a class="dropdown-item" href="{{route('user.create', ['level' => 'provider', 'provider_id' => $provider->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
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
                                    <table id="example1" class="min-w-full divide-y divide-gray-200">
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
                                        {{ $users->links() }}
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
                                {{ ucwords(trans_choice('messages.provider_details', 1)) }}
                            </h3>
                        </div>

                        <div class="flex-shrink-0 mt-2 ml-4">
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $provider->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                {{ ucwords(trans_choice($provider->status->name, 1)) }}
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
                                {{$provider->company_name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.nif', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$provider->nif}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.country', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$provider->country->name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ ucwords(trans_choice('messages.city', 1)) }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$provider->city}}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    @canImpersonate
                    @if(!empty($provider->format()['mainUser']))
                    <x-a color="blue" href="{{ route('impersonate', $provider->format()['mainUser']['id']) }}"><i class="mt-0.5 mr-2 fa fa-user-secret"></i> {{ ucwords(trans_choice('messages.impersonate', 1)) }}</x-a>
                    @endif
                    @endCanImpersonate
                    <x-a href="{{$provider->format()['path']}}/edit" >
                        {{ ucwords(trans_choice('messages.edit', 1)) }}
                    </x-a>
                </div>
                <div>
                    <a href="{{$provider->format()['path']}}/edit" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">{{ ucwords(trans_choice('messages.edit', 1)) }}</a>
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
                            <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $provider->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">

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

    @endsection

