<div class="mx-auto md:max-w-5xl pt-14">
    <div>
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.subscription', 2)) }}</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{$subscriptions->count()}}</dd>
            </div>

            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.licenses', 2)) }}</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{$subscriptions->sum('amount')}}</dd>
            </div>

            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.subscription', 2)) }}</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">58.16%</dd>
            </div>
        </dl>
    </div>
    <div class="mt-4">
        <div class="sm:hidden" x-description="Dropdown menu on small screens">
            <label for="current-tab" class="sr-only">Select a tab</label>
            <select wire:model="filters" id="current-tab" name="current-tab" class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option wire:click="legacy">{{ ucwords(trans_choice('messages.legacy', 1)) }}</option>
                <option wire:click="perpetual">{{ ucwords(trans_choice('messages.perpetual_software', 1)) }}</option>
                <option wire:click="expiration" selected="">{{ ucwords(trans_choice('messages.abouttoexpire', 1)) }}</option>
                <option wire:click="nce" >{{ ucwords(trans_choice('messages.nce', 1)) }}</option>
            </select>
        </div>
        <div class="hidden sm:block" x-description="Tabs at small breakpoint and up" >
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px space-x-8" x-data="{tab: 1}">
                    <a wire:click="resetFilters" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 1}" href="#" @click.prevent="tab = 1">
                        {{ ucwords(trans_choice('messages.all', 1)) }}
                    </a>
                    <a href="#" wire:click="legacy" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 2}" href="#" @click.prevent="tab = 2" @click.prevent="tab = 2">
                        {{ ucwords(trans_choice('messages.legacy', 1)) }}
                    </a>
                    <a href="#" wire:click="perpetual" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 3}" href="#" @click.prevent="tab = 3" @click.prevent="tab = 3">
                        {{ ucwords(trans_choice('messages.perpetual_software', 1)) }}
                    </a>
                    <a href="#" wire:click="expiration" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 4}" href="#" @click.prevent="tab = 4" @click.prevent="tab = 4">
                        {{ ucwords(trans_choice('messages.abouttoexpire', 1)) }}
                    </a>
                    <a href="#" wire:click="nce" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 5}" href="#" @click.prevent="tab = 5" @click.prevent="tab = 5">
                        {{ ucwords(trans_choice('messages.nce', 1)) }}
                    </a>
                </nav>
            </div>
        </div>

        <section class="flex flex-col px-6 py-6 mt-8 mb-16 overflow-hidden rounded-md shadow-lg ">
            <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ ucwords(trans_choice('messages.subscription', 2)) }}</h3>
            </div>
            <div class="px-4 bg-white border-gray-200 sm:px-6">
                <x-bladewind.table striped="true" has_shadow="true" divider="thin" class="rounded-md ">
                    <x-slot name="header">
                        <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.product_term', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.billing', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.amount', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                    </x-slot>
                    @foreach ($subscriptions as $subscription)
                    <tr>
                        <td class="text-left ">
                            <a href="{{$subscription->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                {{$subscription->name}}
                            </a>
                        </td>
                        <td class="text-left ">
                            {{$subscription->term}}
                        </td>
                        <td class="text-left ">
                            {{$subscription->billing_period}}
                        </td>
                        <td class="text-left ">
                            {{$subscription->amount}}
                        </td>
                        <td class="text-left ">
                            @if($subscription->status->name == "messages.canceled")
                            <p class="text-sm text-red-500 ">
                                <svg class="inline-block w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">{{ ucwords(trans_choice($subscription->status->name, 1)) }}</span>
                            </p>
                            @endif
                            @if($subscription->status->name == "messages.inactive")
                            <p class="text-sm text-gray-500 ">
                                <svg class="inline-block w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">{{ ucwords(trans_choice($subscription->status->name, 1)) }}</span>
                            </p>
                            @endif
                            @if($subscription->status->name == "messages.active")
                            <p class="text-sm text-green-500 ">
                                <svg class="inline-block w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">{{ ucwords(trans_choice($subscription->status->name, 1)) }}: Renews on {{$subscription->expiration_data}} </span>
                            </p>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </x-bladewind.table>
            </div>
        </section>
    </div>
</div>
