<div>
    <div>
        <div class="relative z-0 flex-col flex-1 overflow-visible">
            <div class="p-6 bg-transparent">
                <div class="flex flex-col">
                    <div class="flex flex-col items-center justify-between lg:flex-row">
                        <div class="flex items-center">
                            <h4>{{ ucwords(trans_choice('messages.order_table', 2)) }}</h4>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex justify-center flex-1 lg:justify-end">
                                    <!-- Search section -->
                                    <div class="w-full max-w-lg lg:max-w-xs">
                                        <label for="search" class="sr-only">Search</label>
                                        <div class="relative text-gray-400 focus-within:text-gray-500">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <!-- Heroicon name: solid/search -->
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input wire:model.live.debounce.300ms="search" id="search" class="block w-full bg-white py-2 pl-10 pr-3 border border-slate-300 rounded-lg leading-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 sm:text-sm" placeholder="Search orders" type="search" name="search">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="exportSelected()" href="#" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.export', 1)) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <x-tableazure>
                        <x-slot name="head">
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.#', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('user_id')"  :direction="$sorts['user_id'] ?? null">{{ ucwords(trans_choice('messages.user', 1)) }}</x-table.heading>
                            <x-table.heading wire:click="sortBy('company_name')"         :direction="$sorts['company_name'] ?? null">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('details')"       :direction="$sorts['details'] ?? null">{{ ucwords(trans_choice('messages.details', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('created_at')"       :direction="$sorts['created_at'] ?? null">{{ ucwords(trans_choice('messages.created_at', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('order_status_id')"       :direction="$sorts['order_status_id'] ?? null">{{ ucwords(trans_choice('messages.status', 1)) }}</x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($orders as $value)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $value['id'] }}">
                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a href="#" wire:click="show({{ $value['id'] }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $value['id'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="#" wire:click="show({{ $value['id'] }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $value->user->email }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $value->customer->company_name ?? null}}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ \Illuminate\Support\Str::limit($value['details'], 100, $end='...') }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $value->created_at }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                                        {{ $value['status']['name'] }}
                                    </span>
                                </x-table.cell>

                                <x-table.cell class="text-right">
                                    <!-- Fixed-position actions dropdown (Customers-like) -->
                                    <div x-data="{
                                            componentId: @js($this->getId()),
                                            open: false,
                                            top: 0,
                                            left: 0,
                                            width: 0,
                                            place() {
                                                const r = this.$refs.btn.getBoundingClientRect();
                                                this.width = 224;
                                                this.top = r.bottom + 8;
                                                this.left = Math.max(8, r.right - this.width);
                                            },
                                            toggle() {
                                                this.open = !this.open;
                                                if (this.open) this.$nextTick(() => this.place());
                                            },
                                            call(method, id) {
                                                const lw = window.Livewire;
                                                if (!lw || !lw.find) return;
                                                const c = lw.find(this.componentId);
                                                if (!c) return;
                                                c.call(method, id);
                                            }
                                        }"
                                        @keydown.escape.window="open = false"
                                        class="inline-block">

                                        <button type="button" x-ref="btn" @click="toggle()"
                                            class="inline-flex items-center justify-center rounded-lg px-2 py-2 text-slate-600 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                            aria-haspopup="true">
                                            <span class="sr-only">Open actions</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>

                                        <template x-teleport="body">
                                            <div x-cloak x-show="open" @click.away="open = false" @scroll.window="open = false" @resize.window="open = false"
                                                class="fixed z-[9999] w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
                                                :style="`top:${top}px; left:${left}px;`">

                                                <button type="button" @click="call('show', {{ $value->id }}); open = false"
                                                    class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                    <x-icon.show></x-icon.show>
                                                    <span>{{ ucwords(trans_choice('messages.show', 1)) }}</span>
                                                </button>

                                                @if($value->status->id == 3 || $value->status->id == 1)
                                                    <button type="button" @click="call('resendtoMicrosoft', {{ $value->id }}); open = false"
                                                        class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                        <x-icon.refresh></x-icon.refresh>
                                                        <span>{{ ucwords(trans_choice('messages.resendtoMicrosoft', 1)) }}</span>
                                                    </button>
                                                @endif

                                                @if (! $value['verified_at'] && $value['asked_verification_by'] && Auth::user()->can('verify order '.$value['id']))
                                                    <a class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                                       href="{{ route('order.verify', ['order_id' => $value['id']]) }}">
                                                        <x-icon.play></x-icon.play>
                                                        <span>{{ ucwords(__('Verify order')) }}</span>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userlevel->name == "Super Admin" || Auth::user()->userlevel->name == "Provider")
                                                    <div class="border-t border-slate-100"></div>

                                                    @if ($value['status']['id']==3 || $value['status']['id']==2 || $value['status']['id']==1)
                                                        <button type="button" @click="call('markCompleted', {{ $value->id }}); open = false"
                                                            class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                            <span>✓</span>
                                                            <span>{{ ucwords(trans_choice('messages.change_status_complete', 1)) }}</span>
                                                        </button>

                                                        @if ($value['status']['id']==1 || $value['status']['id']==2)
                                                            <button type="button" @click="call('markFailed', {{ $value->id }}); open = false"
                                                                class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                                <span>✕</span>
                                                                <span>{{ ucwords(trans_choice('messages.change_status_failed', 1)) }}</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </template>
                                    </div>
                                </x-table.cell>
                                </x-table.row>
                                @empty
                                <x-table.row>
                                    <x-table.cell colspan="9">
                                        <div class="flex items-center justify-center space-x-2">
                                            <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                            <span class="py-8 text-xl font-medium text-cool-gray-400">{{ ucwords(trans_choice('messages.no_orders', 2)) }}</span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-tableazure>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
            @if($order)
            <x-modal.slideout wire:model.defer="showEditModal">
                <x-slot name="title">{{ ucwords(trans_choice('messages.order', 1)) }} ID {{$order->id}}</x-slot>
                <x-slot name="content">
                    <div class="mt-6" aria-hidden="true">
                        <label for="comment" class="block mb-3 text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.status', 2)) }}</label>
                        <div class="overflow-hidden bg-gray-200 rounded-full">
                            @if ($order['status']['id']==1)
                            <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((5 * 2 + 1) / 8 * 10%);"></div>
                            @endif
                            @if ($order['status']['id']==2)
                            <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((20 * 2 + 1) / 8 * 10%);"></div>
                            @endif
                            @if ($order['status']['id']==4) {{-- completed --}}
                            <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((40 * 2 + 1) / 8 * 10%););"></div>
                            @endif
                        </div>
                        <div class="hidden grid-cols-3 mt-6 text-sm font-medium text-gray-600 sm:grid">
                            <div @if ($order['status']['id']==1) class="text-indigo-600" @endif>{{ ucwords(trans_choice('messages.order_placed', 2)) }}</div>
                            <div @if ($order['status']['id']==2) class="text-center text-indigo-600" @endif class="text-center" >{{ ucwords(trans_choice('messages.running', 2)) }}</div>
                            <div @if ($order['status']['id']==4) class="text-right text-indigo-600" @endif class="text-right" >{{ ucwords(trans_choice('messages.complete', 2)) }}</div>
                        </div>
                    </div>
                    <hr>
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="space-y-2">
                                    <div class="sm:col-span-12 md:col-span-7">
                                        <div class="px-0 py-1 sm:px-6">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                                {{ ucwords(trans_choice('messages.customer', 1)) }}
                                            </h3>
                                        </div>
                                        <dl class="">
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.company_name', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline"href="{{$order->customer->format()['path']}}">
                                                        {{$order->customer['company_name']}}
                                                    </a>

                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.address', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{$order->customer['address_1']}}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.postal_code', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{$order->customer['postal_code']}}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.country', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{$order->customer['country']['name']}}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <hr>

                                    @if(Auth::user()->userlevel->name == "Super Admin")
                                    <div class="sm:col-span-12 md:col-span-7">
                                        <div>
                                            <div class="px-1 py-1 sm:px-6">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">
                                                    {{ ucwords(trans_choice('messages.requestbody', 1)) }}
                                                </h3>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:px-6">
                                                <textarea disabled rows="8" name="requestbody" id="requestbody" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{json_encode(json_decode($order->request_body),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="sm:col-span-12 md:col-span-7">
                                        <div class="px-0 py-1 sm:px-6">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                                {{ ucwords(trans_choice('messages.error', 2)) }}
                                            </h3>
                                        </div>
                                        <dl class="">
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.error', 1)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{json_encode(json_decode($order->errors),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)}}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <span class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">Total Products {{ $order->products->count() }}</span>
                                    @foreach($order->products as $key => $value)
                                    <div class="px-1 py-1 sm:px-6">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                                            {{ ucwords(trans_choice('messages.order_details', 1)) }}
                                        </h3>
                                    </div>
                                    <div class="sm:col-span-12 md:col-span-7">
                                        <dl class="">
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.product', 1)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $value->name }}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.product_term', 1)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $value->pivot->term_duration }}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.billing_cycle', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $value->pivot->billing_cycle }}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.license', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $value->pivot->quantity }}
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.price', 1)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    @php($line = $value->pivot)
                                                    {{ number_format((float)($line->getTotalSellPrice() ?? 0), 2) }}
                                                    @if($line->sell_unit_snapshot === null)
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">Legacy pricing</span>
                                                    @endif
                                                </dd>
                                            </div>
                                            <div class="py-0 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">
                                                    {{ ucwords(trans_choice('messages.details', 2)) }}
                                                </dt>
                                                <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{$order->details}}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </x-slot>
                <x-slot name="footer">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('close', 1))}}
                    </button>
                </x-slot>
            </x-modal.slideout>
            @endif
        </div>
    </div>
