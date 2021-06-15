@extends('layouts.master')
@section('css')
@endsection
@section('content')


<div class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="p-4 overflow-hidden bg-white">
        <div class="flex flex-col items-center justify-between lg:flex-row">
            <div class="flex items-center">
                <h4>{{ ucwords(trans_choice('messages.customer', 1)) }}</h4>
            </div>
        </div>
        <div class="flex flex-col items-center justify-between lg:flex-row">
            <div class="flex items-center">
                <span class="box-border">{{$customer->company_name}}
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                        {{ ucwords(trans_choice($customer->status->name, 1)) }}
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
                                <a href="{{$customer->format()['path']}}/edit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">{{ ucwords(trans_choice('messages.edit', 1)) }} </a>
                            </div>
                            <div class="py-1" role="none">
                                @canImpersonate
                                @if(!empty($customer->format()['mainUser']))
                                <a href="{{ route('impersonate', $customer->format()['mainUser']['id']) }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">Impersonate</a>
                                @endif
                                @endCanImpersonate
                            </div>
                            <div class="py-1" role="none">
                                @if($customer->status->name == 'messages.active')
                                <a href="#" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">Disable</a>
                                @endif
                                @if($customer->status->name != 'messages.active')
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
                <span class="text-xs text-gray-500">{{ date('j F, Y', strtotime($customer->created_at))}}</span>
            </div>
        </div>

        <div class="px-0 pt-0 mt-5 break-words border-b">
            <div class="flex flex-col lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.customer_details', 1)) }}</h4>
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
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->company_name}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($customer->created_at))}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt>
                                @if($customer->microsoftTenantInfo->first())
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <button value="copy" onclick="copyToClipboard('copy_{{ $customer->microsoftTenantInfo->first()->tenant_id }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                        <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                            <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                    <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                    </svg>
                                                </div>
                                                <span >
                                                    <input id="copy_{{ $customer->microsoftTenantInfo->first()->tenant_id }}" value="{{ strtoupper($customer->microsoftTenantInfo->first()->tenant_id) }}" class="inline w-48 mr-1 font-mono text-xs font-normal" />
                                                </span>
                                            </div>
                                        </div>
                                    </button>
                                </dd>
                                @endif
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
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->address_1)}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.city', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->city)}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.country', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->country->name)}}</dd>
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
                    <h4>{{ ucwords(trans_choice('messages.customer_relationship', 1)) }}</h4>
                </div>
            </div>
        </div>

        <div class="grid grid-flow-col grid-cols-2 gap-4">
            <div>
                <div class="flex justify-between mt-4 mb-8">
                    <div class="">
                        <dl>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->company_name}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.main_contact', 1)) }}</dt>
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->users->first()->name}} {{$customer->resellers->first()->users->first()->last_name}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.phone', 1)) }}</dt>
                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->users->first()->phone}}</dd>
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
                                <h4>{{ ucwords(trans_choice('messages.subscription', 2)) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-4 pb-5 m-0">
                        <table class="min-w-full px-4 divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                                    <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.subscription_id', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.amount', 2)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscriptions as $key => $subscription)
                                <tr  class="hover:bg-gray-100">
                                    <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                {{$subscription->products->first()->name}}
                                                <span class="inline text-gray-600">
                                                    •
                                                </span>
                                                {{$subscription->product_id}}
                                            </span>
                                        </div>
                                        @if($subscription->order->first())
                                        <span class="inline text-xs text-gray-600">
                                            {{$subscription->order->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                        <span class="inline font-medium text-gray-900">
                                            <input id="copy_{{ $subscription->subscription_id }}" aria-invalid="false" readonly="" placeholder="" type="text" class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto w-76" value="{{$subscription->subscription_id}}" />
                                        </span>
                                        <span class="inline font-medium text-gray-900">
                                            <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" >
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
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                            <span class="inline text-sm font-normal leading-5">
                                                {{$subscription->amount}}
                                            </span>
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">

                                            @if($subscription->order->first())
                                            <span class="inline text-sm font-normal leading-5">
                                                {{number_format(($subscription->order->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                            </span>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- <div class="px-0 pt-0 pb-5 m-0 text-blue-900 break-words">
                    <div class="p-0 m-0 overflow-visible break-words bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                        <div class="px-0 pt-0 mt-10 break-words border-b">
                            <div class="flex flex-col lg:flex-row">
                                <div class="flex items-center">
                                    <h4>{{ ucwords(trans_choice('messages.order', 1)) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 m-0"> --}}
                            {{-- <div class="p-0 m-0">
                                <table class="w-full max-w-full border-collapse" style="border-spacing: 0px; overflow-wrap: break-word;">
                                    <thead class="box-border" style="overflow-wrap: break-word;">
                                        <tr class="h-full text-gray-700" style="overflow-wrap: break-word;"></tr>
                                    </thead>
                                    <tbody class="box-border" style="overflow-wrap: break-word;">
                                        @foreach ($subscriptions as $key => $subscription)
                                        <tr class="h-full text-gray-700 cursor-pointer hover:bg-gray-100 focus:bg-gray-100" style="overflow-wrap: break-word;">
                                            <td class="w-auto h-px p-0 m-0 text-left whitespace-normal align-top shadow-xs" style="height: 1px; outline: 0px; word-break: break-word; overflow-wrap: break-word;">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                        <span class="inline text-sm font-normal leading-5">
                                                            <span class="box-border" style="font-variant: proportional-nums; word-break: break-word; overflow-wrap: break-word;">
                                                                {{$subscription->order->first()->user->name}} {{$subscription->user->last_name}} / {{$subscription->details, 'LIKE', '%'.$customer->name.'%'}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="w-px h-px p-0 m-0 text-right whitespace-normal align-top shadow-xs" style="height: 1px; outline: 0px; word-break: break-word; overflow-wrap: break-word;">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full p-2 m-0 overflow-auto">
                                                        <span class="inline text-sm font-normal leading-5">
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="w-px h-px p-0 m-0 text-right text-gray-500 align-top shadow-xs whitespace-nowrap">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full py-2 pl-2 pr-1 m-0">
                                                        <span class="inline text-sm font-normal leading-5 text-gray-600">
                                                            <span class="box-border">{{$subscription->created_at}}</span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a class="font-medium text-indigo-600 no-underline bg-transparent cursor-pointer hover:text-gray-900 hover:no-underline focus:shadow-xs" href="/events?related_object=sub_JDdMJBanJrIVHp">
                                <div class="text-gray-900" style="overflow-wrap: break-word;">
                                    <span class="box-border" style="overflow-wrap: break-word;">
                                        View more events
                                    </span>
                                </div>
                            </a> --}}
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



    {{-- <div class="max-w-2xl px-4 mx-auto sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-full lg:px-8">
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
                @forelse($customer as $key => $item)
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
                                No customer yet
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
                                                            <div x-cloak x-data="{ open: false }">
                                                                <a href="{{ route('user.edit', $user) }}" class="btn btn-icon edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-icon"  @click="open = true">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                @canBeImpersonated($user)
                                                                <a href="{{ route('impersonate', $user) }}"class="btn btn-icon edit">
                                                                    <i class="mr-2 fa fa-user-secret"></i>
                                                                </a>
                                                                @endCanBeImpersonated
                                                                <div x-cloak x-show="open" class="fixed z-10 items-center justify-center overflow-y-auto inset-20" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                                                                        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                                                                <div class="sm:flex sm:items-start">
                                                                                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                                                        <!-- Heroicon name: outline/exclamation -->
                                                                                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                                        </svg>
                                                                                    </div>
                                                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                                                                            Delete account
                                                                                        </h3>
                                                                                        <div class="mt-2">
                                                                                            <p class="text-sm text-gray-500">
                                                                                                Are you sure you want to <strong>Delete {{$user->name}} </strong> account? All of your data will be permanently removed. This action cannot be undone.
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                                <form action="{{ route('user.destroy', $user) }}" method="POST">
                                                                                    @method('DELETE')
                                                                                    @csrf
                                                                                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                                <button type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false" >
                                                                                    Cancel
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
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

                                <div class="flex-shrink-0 mt-2 ml-4">
                                    <p class="inline-flex px-2 text-xs ml-3 font-semibold leading-5 {{ $customer->status->name == 'messages.active' ? ' text-green-800 bg-green-100' : ' text-yellow-800 bg-yellow-100'  }} rounded-full">
                                        {{ ucwords(trans_choice($customer->status->name, 1)) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="sm:col-span-1">
                                    @if($customer->customer->count() >= 1)
                                    <dd class="text-xs text-gray-500">
                                        {{$customer->customer->first()->tenant_name }}

                                    </dd>
                                    <dd class="text-xs text-gray-500">
                                        {{$customer->microsoftTenantInfo->first()->tenant_id }}
                                    </dd>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
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
                                @if($customer->priceLists->first())
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.price_list', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{$customer->priceLists->first()->name}}
                                    </dd>
                                </div>
                                @endif
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
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            @canImpersonate
                            @if(!empty($customer->format()['mainUser']))
                            <x-a color="blue" href="{{ route('impersonate', $customer->format()['mainUser']['id']) }}"><i class="mt-0.5 mr-2 fa fa-user-secret"></i> {{ ucwords(trans_choice('messages.impersonate', 1)) }}</x-a>
                            @endif
                            @endCanImpersonate
                            <x-a href="{{$customer->format()['path']}}/edit" >
                                {{ ucwords(trans_choice('messages.edit', 1)) }}
                            </x-a>
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
        </div> --}}

        {{-- @endsection --}}


