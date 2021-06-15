@extends('layouts.master')
@section('css')
@endsection
@section('content')

<div class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="p-4 overflow-hidden bg-white">
        <div class="flex flex-col items-center justify-between lg:flex-row">
            <div class="flex items-center">
                <h4>{{ ucwords(trans_choice('messages.subscription', 1)) }}</h4>
            </div>
        </div>
        <div class="flex flex-col items-center justify-between lg:flex-row">
            <div class="flex items-center">
                <span class="box-border">{{$subscriptions->customer->company_name}}
                    <span class="text-xl font-normal text-gray-600">on</span>
                    <span class="text-xl font-normal">{{$subscriptions->name}}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscriptions->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                        {{ ucwords(trans_choice($subscriptions->status->name, 1)) }}
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">Edit Subscription</a>
                            </div>
                            <div class="py-1" role="none">
                                @if($subscriptions->status->name == 'messages.active')
                                <a href="#" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">Disable</a>
                                @endif
                                @if($subscriptions->status->name != 'messages.active')
                                <a href="#" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">Enable</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-32 p-0 px-1 py-2 m-0 border-r shadow-xs">
            <span class="font-bold">{{ ucwords(trans_choice('messages.subscription_started', 1)) }}</span>
            <div>
                <span class="text-xs text-gray-500">{{$subscriptions->created_at}}</span>
            </div>
        </div>

        <div class="px-0 pt-0 mt-10 break-words border-b">
            <div class="flex flex-col lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.subscription_details', 1)) }}</h4>
                </div>
            </div>
        </div>

        <div class="grid grid-flow-col grid-cols-2 gap-4">
            <div>
                <div class="flex justify-between mt-4 mb-8">
                    <div class="">
                        <dl>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.customer', 1)) }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$subscriptions->customer->company_name}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$subscriptions->created_at}}</dd>
                            </div>
                            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.subscription_period', 1)) }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($subscriptions->created_at)) }} <strong>to</strong> {{date('j F, Y', strtotime($subscriptions->expiration_data))}}</dd>
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
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($subscriptions->billing_period)}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $subscriptions->tenant_name }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                            <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                                <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                    <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                        </svg>
                                                    </div>
                                                    <span >
                                                        <input id="copy_{{ $subscriptions->tenant_name }}" value="{{ strtoupper($subscriptions->tenant_name) }}" class="inline w-48 mr-1 font-mono text-xs font-normal" />
                                                    </span>
                                                </div>
                                            </div>
                                        </button>
                                    </dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.subscription_id', 2)) }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span class="inline font-mono text-xs font-normal">
                                            {{$subscriptions->subscription_id}}
                                        </span>
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $subscriptions->subscription_id }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                            <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                                <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                    <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </dd>
                                </div>
                            </dl>
                        </div>
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
                                <h4>{{ ucwords(trans_choice('messages.price', 2)) }}</h4>
                            </div>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.product', 2)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.subscription_id', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.amount', 2)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                            </tr>
                        </thead>
                        <tbody class="box-border" style="overflow-wrap: break-word;">
                            <tr class="table-subheader hover:bg-gray-100">
                                <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                        <span class="inline font-medium text-gray-900">
                                            {{$subscriptions->products->first()->name}}
                                            <span class="inline text-gray-600">
                                                •
                                            </span>
                                            {{$subscriptions->product_id}}
                                        </span>
                                    </div>
                                    @if($subscriptions->order->first())
                                    <span class="inline text-xs text-gray-600">
                                        {{$subscriptions->order->first()->orderproduct->retail_price}} {{$subscriptions->currency}} / {{$subscriptions->billing_period}}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                    <span class="inline font-medium text-gray-900">
                                        <input id="copy_{{ $subscriptions->subscription_id }}" aria-invalid="false" readonly="" placeholder="" type="text" class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto w-76" value="{{$subscriptions->subscription_id}}" />
                                    </span>
                                    <span class="inline font-medium text-gray-900">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $subscriptions->subscription_id }}')" >
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
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="inline text-sm font-normal leading-5">
                                                {{$subscriptions->amount}}
                                            </span>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">

                                            @if($subscriptions->order->first())
                                            <span class="inline text-sm font-normal leading-5">
                                                {{number_format(($subscriptions->order->first()->orderproduct->retail_price*$subscriptions->amount)*($subscriptions->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscriptions->currency}} / {{$subscriptions->billing_period}}
                                            </span>
                                            @endif

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="px-0 pt-0 pb-5 m-0 text-blue-900 break-words">
                    <div class="p-0 m-0 overflow-visible break-words bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                        <div class="px-0 pt-0 mt-10 break-words border-b">
                            <div class="flex flex-col lg:flex-row">
                                <div class="flex items-center">
                                    <h4>{{ ucwords(trans_choice('messages.order', 1)) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 m-0">
                            <div class="p-0 m-0">
                                <table class="w-full max-w-full border-collapse" style="border-spacing: 0px; overflow-wrap: break-word;">
                                    <thead class="box-border" style="overflow-wrap: break-word;">
                                        <tr class="h-full text-gray-700" style="overflow-wrap: break-word;"></tr>
                                    </thead>
                                    <tbody class="box-border" style="overflow-wrap: break-word;">
                                        @foreach ($subscriptions->order as $item)
                                        <tr class="h-full text-gray-700 cursor-pointer hover:bg-gray-100 focus:bg-gray-100" style="overflow-wrap: break-word;">
                                            <td class="w-auto h-px p-0 m-0 text-left whitespace-normal align-top shadow-xs" style="height: 1px; outline: 0px; word-break: break-word; overflow-wrap: break-word;">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                        <span class="inline text-sm font-normal leading-5">
                                                            <span class="box-border" style="font-variant: proportional-nums; word-break: break-word; overflow-wrap: break-word;">
                                                                {{$item->user->name}} {{$item->user->last_name}} / {{$item->details, 'LIKE', '%'.$subscriptions->name.'%'}}
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
                                                            <span class="box-border">{{$item->created_at}}</span>
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
                            </a>
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

