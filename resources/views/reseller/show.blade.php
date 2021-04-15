@extends('layouts.master')
@section('css')
<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- File Uploads css -->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!-- Time picker css -->
<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
<!-- Date Picker css -->
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
<!-- File Uploads css-->
<link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!--Mutipleselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
<!--Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--intlTelInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')}}">
<!--Jquerytransfer css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')}}">
<!--multi css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multi/multi.min.css')}}">
@endsection

@section('content')

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
        {{-- <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select id="tabs" name="tabs" class="block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                <option @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" selected>My Account</option>

                <option @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }">Company</option>

                <option @click="openTab = 3" :class="{ '-mb-px': openTab === 3 }" >Team Members</option>

                <option @click="openTab = 4" :class="{ '-mb-px': openTab === 4 }">Billing</option>
            </select>
        </div> --}}
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
                    </div>                    <div class="px-4 py-5 border-t sm:px-6">
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


        <!-- Description list-->
        {{-- <div class="overflow-hidden bg-white shadow sm:rounded-md">
            <!-- This example requires Tailwind CSS v2.0+ -->

        </div>

        <section aria-labelledby="applicant-information-title">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                        <div class="mt-2 ml-4">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ ucwords(trans_choice('messages.customer', 2)) }}
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
                                    @include('customer.partials.table', ['customers' => $customers])
                                </div>
                                <div class="tab-pane" id="tab-9">
                                    @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                        </table> --}}
                                        {{-- {{ $users->links() }} --}}
                                        {{-- </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> --}}
                </div>
                <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                                <div class="mt-2 ml-4">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        {{ ucwords(trans_choice('messages.provider_details', 1)) }}
                                    </h3>
                                    @canImpersonate
                                    @if(!empty($reseller->format()['mainUser']))
                                    <a class="btn btn-white" href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}"><i class="fa fa-user-secret"></i>{{ ucwords(trans_choice('messages.impersonate', 1)) }}</a>
                                    @endif
                                    @endCanImpersonate
                                </div>

                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $reseller->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                        {{ ucwords(trans_choice($reseller->status->name, 1)) }}
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
                            </dl>
                        </div>
                        <div>
                            <a href="{{$reseller->format()['path']}}/edit" class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">{{ ucwords(trans_choice('messages.edit', 1)) }}</a>
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
            </div>

            <!--/app header-->
            {{-- <div class="main-proifle">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box-widget widget-user">
                            <div class="widget-user-image ">
                                <div class="mt-4 ml-sm-4">
                                    <div class="mb-1 d-flex">
                                        <div class="mt-1 mr-3 media-icon bg-danger-transparent text-danger">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">{{ucwords(trans_choice('messages.company_name', 1))}} </small>
                                            <div class="font-weight-bold">
                                                {{$reseller->company_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <div class="mt-1 mr-3 media-icon bg-info-transparent text-info">
                                            <i class="fa fa-map"></i>
                                        </div>
                                        <div class="media-body">
                                            <small class="text-muted">{{ucwords(trans_choice('messages.address_1', 1))}} </small>
                                            <div class="font-weight-bold">
                                                {{$reseller->address_1}} <br>
                                                {{$reseller->city}}, {{$reseller->state}}, {{$reseller->postal_code}}
                                                {{$reseller->country->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="d-flex">
                            <div class="mt-1 mr-3 media-icon bg-warning-transparent text-warning">
                                <i class="fa fa-slack"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">{{ ucwords(trans_choice('messages.mpnid', 1)) }} </small>
                                <div class="font-weight-bold">
                                    {{$reseller->mpnid}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-auto">
                        <div class="mt-4 text-lg-right mt-lg-0">
                            @canImpersonate
                            @if(!empty($reseller->format()['mainUser']))
                            <a class="btn btn-white" href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}"><i class="fa fa-user-secret"></i>{{ ucwords(trans_choice('messages.impersonate', 1)) }}</a>

                            @endif
                            @endCanImpersonate
                            <a href="{{$reseller->format()['path']}}/edit" class="btn btn-primary">{{ ucwords(trans_choice('messages.edit_reseller', 1)) }} </a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-auto">
                        <div class="mt-5">
                            <div class="main-profile-contact-list row">
                                <div class="media col-sm-4">
                                    <div class="mt-1 mr-3 media-icon bg-light text-primary">
                                        <i class="fa fa-users fs-18"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">{{ ucwords(trans_choice('messages.customer', 2)) }}</small>
                                        <div class="font-weight-bold fs-25">
                                            {{$customers->count()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="media col-sm-4">
                                    <div class="mt-1 mr-3 media-icon bg-light text-primary">
                                        <i class="fa fa-connectdevelop fs-18"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">{{ ucwords(trans_choice('messages.subscription', 2)) }}</small>
                                        <div class="font-weight-bold fs-25">
                                            {{$subscriptions->count()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="media col-sm-4">
                                    <div class="mt-1 mr-3 media-icon bg-light text-primary">
                                        <i class="fa fa-feed fs-18"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">{{ ucwords(trans_choice('messages.order', 2)) }}</small>
                                        <div class="font-weight-bold fs-25">
                                            {{$reseller->orders}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-cover">
                    <div class="wideget-user-tab">
                        <div class="p-0 tab-menu-heading">
                            <div class="px-3 tabs-menu1">
                                <ul class="nav">
                                    <li><a href="#tab-7" class="active" data-toggle="tab">{{ ucwords(trans_choice('messages.details', 2)) }}</a></li>
                                    <li><a href="#tab-8" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.customer', 2)) }}</a></li>
                                    <li><a href="#tab-9" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a></li>
                                    <li><a href="#tab-10" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.user', 2)) }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!-- /.profile-cover -->
            </div>
            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="border-0">
                        <div class="tab-content">
                            <div class="tab-pane active"  id="tab-7">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Details</h5>
                                        <p class="card-text">Content</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-8">
                                @include('customer.partials.table', ['customers' => $customers])
                            </div>
                            <div class="tab-pane" id="tab-9">
                                @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
                            </div>

                            <div class="tab-pane" id="tab-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ ucwords(trans_choice('messages.user_table', 2)) }}</h3>
                                        <div class="card-options">
                                            <div class="mb-0 ml-5 btn-group">
                                                <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('user.create', ['level' => 'reseller', 'reseller_id'=> $reseller->id])}}"><i class="mr-2 fa fa-plus"></i>{{ ucwords(__('messages.new_user')) }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @include('user.partials.table', ['users' => $users])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            @endsection

            @section('js')
            <!--Select2 js -->
            <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
            <script src="{{URL::asset('assets/js/select2.js')}}"></script>
            <!-- Timepicker js -->
            <script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>
            <!-- Datepicker js -->
            <script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
            <!--File-Uploads Js-->
            <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
            <!-- File uploads js -->
            <script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
            <script src="{{URL::asset('assets/js/filupload.js')}}"></script>
            <!-- Multiple select js -->
            <script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
            <!--Sumoselect js-->
            <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
            <!--intlTelInput js-->
            <script src="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/intl-tel-input-master/country-select.js')}}"></script>
            <script src="{{URL::asset('assets/plugins/intl-tel-input-master/utils.js')}}"></script>
            <!--jquery transfer js-->
            <script src="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.js')}}"></script>
            <!--multi js-->
            <script src="{{URL::asset('assets/plugins/multi/multi.min.js')}}"></script>
            <!-- Form Advanced Element -->
            <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
            <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
            <script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
            @endsection


