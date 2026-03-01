<div>
    @php
        /** @var \App\Provider $provider */
        $provider->loadMissing(['status', 'country', 'instances', 'users']);
        $instances = $provider->instances->sortByDesc('id');
    @endphp

    <div class="p-6">
        <!-- Header (inside card) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-semibold text-slate-900">{{ $provider->company_name }}</h3>
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset
                        {{ ($provider->status->name ?? '') === 'messages.active' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-amber-50 text-amber-700 ring-amber-200' }}">
                        {{ ucwords(trans_choice($provider->status->name ?? 'messages.active', 1)) }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-slate-600">
                    Provider ID: <span class="font-medium text-slate-900">{{ $provider->id }}</span>
                    <span class="text-slate-300">•</span>
                    Created: <span class="font-medium text-slate-900">{{ optional($provider->created_at)->format('Y-m-d') ?? '—' }}</span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @canImpersonate
                    @if(!empty($provider->format()['mainUser']))
                        <a href="{{ route('impersonate', $provider->format()['mainUser']['id']) }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <x-icon.switch />
                            Impersonate
                        </a>
                    @endif
                @endCanImpersonate

                <a href="{{ route('instances.create', ['provider' => $provider->id]) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                    <x-icon.plus />
                    Add instance
                </a>

                <a href="{{ route('provider.edit', $provider->id) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                    <x-icon.edit />
                    Edit provider
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Instances -->
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-4">
                        <div>
                            <h4 class="text-base font-semibold text-slate-900">Instances</h4>
                            <p class="mt-1 text-sm text-slate-600">Microsoft / Kaspersky instances for this provider.</p>
                        </div>
                        <a href="{{ route('instances.index') }}"
                           class="text-sm font-semibold text-primary-700 hover:text-primary-800">View all</a>
                    </div>

                    <div class="px-6 py-4">
                        @if($instances->count() === 0)
                            <div class="flex items-center justify-center gap-2 py-10 text-slate-500">
                                <x-icon.inbox class="h-6 w-6" />
                                <span class="text-sm font-medium">No instances yet.</span>
                            </div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">CSP mode</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Expires</th>
                                            <th class="px-4 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($instances as $instance)
                                            <tr class="hover:bg-slate-50/60">
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                                    <a class="hover:text-primary-700" href="{{ route('instances.edit', $instance->id) }}">{{ $instance->name }}</a>
                                                    @if(method_exists($instance, 'isExpired') && $instance->isExpired())
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Expired</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ $instance->type ?? '—' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-700">
                                                    @if(($instance->type ?? '') === 'Microsoft')
                                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                                                            {{ $instance->external_type ?? '—' }}
                                                        </span>
                                                    @else
                                                        <span class="text-slate-400">—</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ optional($instance->expires_at)->format('Y-m-d') ?? '—' }}</td>
                                                <td class="px-4 py-3 text-right">
                                                    <a href="{{ route('instances.edit', $instance->id) }}"
                                                       class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                                                        <x-icon.edit />
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users (simple, no legacy datatables) -->
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Users</h4>
                        <p class="mt-1 text-sm text-slate-600">Users assigned to this provider.</p>
                    </div>
                    <div class="px-6 py-4">
                        @php($users = $provider->users)
                        @if($users->count() === 0)
                            <div class="flex items-center justify-center gap-2 py-10 text-slate-500">
                                <x-icon.inbox class="h-6 w-6" />
                                <span class="text-sm font-medium">No users assigned.</span>
                            </div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Email</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($users as $u)
                                            <tr class="hover:bg-slate-50/60">
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ trim(($u->name ?? '') . ' ' . ($u->last_name ?? '')) ?: '—' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ $u->email }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ ucwords(trans_choice($u->status->name ?? 'messages.active', 1)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Details</h4>
                        <p class="mt-1 text-sm text-slate-600">Company and billing basics.</p>
                    </div>
                    <div class="px-6 py-4 text-sm">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">NIF</span>
                                <span class="font-medium text-slate-900">{{ $provider->nif ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">Country</span>
                                <span class="font-medium text-slate-900">{{ $provider->country->name ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">City</span>
                                <span class="font-medium text-slate-900">{{ $provider->city ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">State</span>
                                <span class="font-medium text-slate-900">{{ $provider->state ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">Postal</span>
                                <span class="font-medium text-slate-900">{{ $provider->postal_code ?? '—' }}</span>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-slate-200 pt-4">
                            <a href="{{ route('provider.price_lists', $provider->id) }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <x-icon.show />
                                View price list
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 text-xs text-slate-600">
                    <div class="font-semibold text-slate-900">Note</div>
                    <div class="mt-1">This screen was simplified to match the new UI. If you want, we can add tabs (Instances / Users / Billing) next.</div>
                </div>
            </div>
        </div>
    </div>
</div>
