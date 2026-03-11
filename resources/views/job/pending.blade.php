<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Pending Jobs</h2>
            <p class="mt-1 text-sm text-slate-600">{{ $total }} job{{ $total !== 1 ? 's' : '' }} waiting in queue.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    <x-tableazure>
                        <x-slot name="head">
                            <x-table.heading>#</x-table.heading>
                            <x-table.heading>Job</x-table.heading>
                            <x-table.heading>Queue</x-table.heading>
                            <x-table.heading>Attempts</x-table.heading>
                            <x-table.heading>Status</x-table.heading>
                            <x-table.heading>Available At</x-table.heading>
                            <x-table.heading>Queued At</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @forelse ($jobs as $job)
                            <x-table.row wire:key="row-{{ $job->id }}">
                                <x-table.cell>
                                    <span class="text-sm font-mono text-slate-500">{{ $job->id }}</span>
                                </x-table.cell>

                                <x-table.cell>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">
                                            {{ class_basename($job->payload->displayName ?? $job->payload->job ?? 'Unknown') }}
                                        </p>
                                        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $job->payload->uuid ?? '' }}</p>
                                    </div>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                                        {{ $job->queue }}
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="text-sm text-slate-700">{{ $job->attempts }}</span>
                                    @if(($job->payload->maxTries ?? null))
                                    <span class="text-xs text-slate-400">/ {{ $job->payload->maxTries }}</span>
                                    @endif
                                </x-table.cell>

                                <x-table.cell>
                                    @if($job->reserved_at)
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-200">
                                            Running
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
                                            Waiting
                                        </span>
                                    @endif
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="text-sm text-slate-600">
                                        {{ \Carbon\Carbon::createFromTimestamp($job->available_at)->diffForHumans() }}
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}
                                    </span>
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="7">
                                    <div class="flex items-center justify-center space-x-2 py-8">
                                        <x-icon.inbox class="w-8 h-8 text-slate-300" />
                                        <span class="text-xl font-medium text-slate-400">No pending jobs.</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-tableazure>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
