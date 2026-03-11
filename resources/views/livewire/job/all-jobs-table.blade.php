<div>
    {{-- Flash message --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header toolbar --}}
    <div class="p-6 pb-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            {{-- Tabs --}}
            <nav class="flex gap-1" aria-label="Tabs">
                @foreach ([
                    'all'     => 'All',
                    'pending' => 'Pending',
                    'failed'  => 'Failed',
                    'history' => 'History',
                ] as $key => $label)
                    <button
                        wire:click="$set('tab', '{{ $key }}')"
                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                            {{ $tab === $key
                                ? 'bg-slate-900 text-white'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        {{ $label }}
                        <span class="rounded-full px-1.5 py-0.5 text-xs
                            {{ $tab === $key ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                            {{ $counts[$key] ?? 0 }}
                        </span>
                    </button>
                @endforeach
            </nav>

            {{-- Search --}}
            <div class="relative w-full max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search"
                    type="search" placeholder="Search jobs…"
                    class="block w-full rounded-lg border border-slate-300 bg-white py-2 pl-9 pr-3 text-sm text-slate-900 placeholder-slate-400
                           focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
            </div>
        </div>
    </div>

    {{-- Table — wrapper provides the sm:px-6 lg:px-8 context that tableazure's
         sm:-mx-6 lg:-mx-8 negative margins are designed to pull against --}}
    <div class="sm:px-6 lg:px-8">
    <x-tableazure>
        <x-slot name="head">
            <x-table.heading>Job</x-table.heading>
            <x-table.heading>Queue</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Attempts</x-table.heading>
            <x-table.heading>Order</x-table.heading>
            <x-table.heading>When</x-table.heading>
            <x-table.heading></x-table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse ($jobs as $job)
                <x-table.row wire:key="row-{{ $job['source'] }}-{{ $job['id'] }}"
                    class="cursor-pointer hover:bg-slate-50"
                    wire:click="show('{{ $job['source'] }}', {{ $job['id'] }})">

                    {{-- Job name --}}
                    <x-table.cell class="max-w-xs">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $job['name'] }}</p>
                            <p class="truncate font-mono text-xs text-slate-400">{{ Str::limit($job['uuid'], 36) }}</p>
                        </div>
                    </x-table.cell>

                    {{-- Queue --}}
                    <x-table.cell>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                            {{ $job['queue'] }}
                        </span>
                    </x-table.cell>

                    {{-- Status --}}
                    <x-table.cell>
                        @php
                            $badges = [
                                'waiting'   => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
                                'running'   => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',
                                'completed' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200',
                                'failed'    => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
                            ];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badges[$job['status']] ?? '' }}">
                            {{ ucfirst($job['status']) }}
                        </span>
                    </x-table.cell>

                    {{-- Attempts --}}
                    <x-table.cell>
                        <span class="text-sm text-slate-700">{{ $job['attempts'] }}</span>
                        @if($job['max_tries'])
                            <span class="text-xs text-slate-400"> / {{ $job['max_tries'] }}</span>
                        @endif
                    </x-table.cell>

                    {{-- Order ID --}}
                    <x-table.cell>
                        @if($job['order_id'])
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                #{{ $job['order_id'] }}
                            </span>
                        @else
                            <span class="text-xs text-slate-400">—</span>
                        @endif
                    </x-table.cell>

                    {{-- When --}}
                    <x-table.cell>
                        <span class="text-sm text-slate-500">
                            {{ $job['created_at'] ? $job['created_at']->diffForHumans() : '—' }}
                        </span>
                        @if($job['elapsed'])
                            <p class="text-xs text-slate-400">{{ number_format((float)$job['elapsed'], 2) }}s</p>
                        @endif
                    </x-table.cell>

                    {{-- Actions --}}
                    <x-table.cell class="text-right">
                        <button wire:click.stop="show('{{ $job['source'] }}', {{ $job['id'] }})"
                            class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="7">
                        <div class="flex items-center justify-center space-x-2 py-10">
                            <x-icon.inbox class="h-8 w-8 text-slate-300" />
                            <span class="text-lg font-medium text-slate-400">No jobs found.</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-tableazure>
    </div>{{-- /sm:px-6 lg:px-8 tableazure context --}}

    {{-- Pagination --}}
    <div class="px-6 py-4">
        {{ $jobs->links() }}
    </div>

    {{-- ─── Slideout detail panel ──────────────────────────────────────────── --}}
    @if($showSlideout && $selected)
        <div class="fixed inset-0 z-50 overflow-hidden" aria-modal="true">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
                 wire:click="closeSlideout"></div>

            {{-- Panel --}}
            <div class="absolute inset-y-0 right-0 flex w-full max-w-xl flex-col bg-white shadow-2xl">

                {{-- Panel header --}}
                <div class="flex items-start justify-between border-b border-slate-200 px-6 py-5">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">{{ $selected['name'] }}</h3>
                        <p class="mt-1 font-mono text-xs text-slate-400">{{ $selected['full_name'] }}</p>
                    </div>
                    <button wire:click="closeSlideout"
                        class="ml-4 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                {{-- Scrollable body --}}
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-6">

                    {{-- Status badge --}}
                    @php
                        $badges = [
                            'waiting'   => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
                            'running'   => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200',
                            'completed' => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200',
                            'failed'    => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $badges[$selected['status']] ?? '' }}">
                        {{ ucfirst($selected['status']) }}
                    </span>

                    {{-- Job details --}}
                    <div>
                        <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Job Details</h4>
                        <dl class="divide-y divide-slate-100 rounded-xl border border-slate-200">
                            @foreach ([
                                'UUID'        => $selected['uuid'],
                                'Queue'       => $selected['queue'],
                                'Source'      => ucfirst($selected['source']),
                                'Attempts'    => ($selected['max_tries'] ? $selected['attempts'] . ' / ' . $selected['max_tries'] : $selected['attempts']),
                                'Backoff'     => $selected['backoff'],
                                'Elapsed'     => $selected['elapsed'] ? number_format((float)$selected['elapsed'], 2) . 's' : null,
                            ] as $label => $value)
                                @if($value !== null && $value !== '')
                                    <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                        <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                                        <dd class="col-span-2 text-sm text-slate-900 font-mono break-all">{{ $value }}</dd>
                                    </div>
                                @endif
                            @endforeach
                            @if($selected['started_at'])
                                <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                    <dt class="text-sm font-medium text-slate-500">Started</dt>
                                    <dd class="col-span-2 text-sm text-slate-900">{{ $selected['started_at'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($selected['finished_at']))
                                <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                    <dt class="text-sm font-medium text-slate-500">Finished</dt>
                                    <dd class="col-span-2 text-sm text-slate-900">{{ $selected['finished_at'] }}</dd>
                                </div>
                            @endif
                            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                                <dt class="text-sm font-medium text-slate-500">Queued</dt>
                                <dd class="col-span-2 text-sm text-slate-900">
                                    {{ $selected['created_at'] ? $selected['created_at']->format('Y-m-d H:i:s') : '—' }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Related order --}}
                    @if(!empty($selected['order']))
                        @php $order = $selected['order']; @endphp
                        <div>
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Related Order</h4>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">
                                            Order #{{ $order['id'] }}
                                            @if($order['company_name'])
                                                <span class="font-normal text-slate-500">— {{ $order['company_name'] }}</span>
                                            @endif
                                        </p>
                                        @if($order['details'])
                                            <p class="mt-1 text-xs text-slate-500">{{ Str::limit($order['details'], 80) }}</p>
                                        @endif
                                    </div>
                                    @php
                                        $orderBadges = [1 => 'bg-amber-50 text-amber-700 ring-amber-200', 2 => 'bg-blue-50 text-blue-700 ring-blue-200', 3 => 'bg-red-50 text-red-700 ring-red-200', 4 => 'bg-green-50 text-green-700 ring-green-200'];
                                        $ob = $orderBadges[$order['status_id']] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
                                    @endphp
                                    <span class="ml-4 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $ob }}">
                                        {{ $order['status'] }}
                                    </span>
                                </div>
                                <a href="{{ $order['url'] }}"
                                    class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-primary-600 hover:text-primary-700">
                                    View order
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @elseif($selected['order_id'])
                        <div>
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Related Order</h4>
                            <p class="text-sm text-slate-500">Order #{{ $selected['order_id'] }} — could not be loaded.</p>
                        </div>
                    @endif

                    {{-- Error details --}}
                    @if(!empty($selected['exception_message']) || !empty($selected['exception']))
                        <div>
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wide text-red-500">Error</h4>
                            @if(!empty($selected['exception_class']))
                                <p class="mb-2 text-xs font-semibold text-slate-700">{{ $selected['exception_class'] }}</p>
                            @endif
                            @if(!empty($selected['exception_message']))
                                <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                    {{ $selected['exception_message'] }}
                                </div>
                            @endif
                            @if(!empty($selected['exception']))
                                <details class="group">
                                    <summary class="cursor-pointer text-xs font-semibold text-slate-500 hover:text-slate-700">
                                        Full stack trace
                                    </summary>
                                    <pre class="mt-2 max-h-64 overflow-auto rounded-lg border border-slate-200 bg-slate-50 p-3 text-xs text-slate-700">{{ $selected['exception'] }}</pre>
                                </details>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- Panel footer / actions --}}
                @if($selected['source'] === 'failed')
                    <div class="flex items-center justify-between border-t border-slate-200 bg-slate-50 px-6 py-4">
                        <button
                            wire:click="deleteFailed({{ $selected['id'] }})"
                            onclick="return confirm('Delete this failed job permanently?')"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                        <button
                            wire:click="retryFailed({{ $selected['id'] }})"
                            class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-4 focus:ring-slate-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Re-queue job
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
