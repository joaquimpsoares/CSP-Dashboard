<div x-data="{ addInstanceOpen: false }">
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

                <button type="button" @click="addInstanceOpen = true"
                   class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                    <x-icon.plus />
                    Add instance
                </button>

                <a href="{{ route('provider.edit', $provider->id) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                    <x-icon.edit />
                    Edit provider
                </a>
            </div>
        </div>

        @php
            // Relationships
            $provider->loadMissing(['resellers', 'resellers.customers', 'resellers.status', 'users']);

            // Determine DIRECT vs INDIRECT from provider instances (external_type).
            // Direct resellers sell to customers directly; indirect resellers have child resellers.
            $isDirect = $instances->contains(fn($i) => ($i->external_type ?? null) === 'direct_reseller');

            // Resellers list is only meaningful for indirect providers.
            $resellersAll = $provider->resellers;

            // Customers for direct providers (sold directly without resellers)
            $directCustomers = collect();
            if ($isDirect) {
                try {
                    $customerIds = method_exists($provider, 'getMyCustomersId') ? $provider->getMyCustomersId() : [];
                    $directCustomers = \App\Customer::query()->whereIn('id', $customerIds)->limit(50)->get();
                } catch (\Throwable $e) {
                    $directCustomers = collect();
                }
            }

            $usersCount = $provider->users->count();
            $instancesCount = $instances->count();
            $resellersCount = $isDirect ? 0 : $resellersAll->count();

            $customersCount = 0;
            if ($isDirect) {
                $customersCount = $directCustomers->count();
            } else {
                $ids = method_exists($provider, 'getMyCustomersId') ? $provider->getMyCustomersId() : [];
                $customersCount = is_array($ids) ? count($ids) : 0;
            }
        @endphp

        <!-- Summary cards -->
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                <div class="text-sm font-medium text-slate-600">Instances</div>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $instancesCount }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                <div class="text-sm font-medium text-slate-600">{{ $isDirect ? 'Customers' : 'Resellers' }}</div>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $isDirect ? $customersCount : $resellersCount }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                <div class="text-sm font-medium text-slate-600">Users</div>
                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $usersCount }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                <div class="text-sm font-medium text-slate-600">Billing</div>
                <div class="mt-2 text-sm font-semibold text-slate-900">Coming soon</div>
                <div class="mt-1 text-xs text-slate-500">Stripe-like billing view</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mt-6" x-data="{ tab: 'details' }">
            <div class="border-b border-slate-200">
                <nav class="-mb-px flex flex-wrap gap-6">
                    <button type="button" @click="tab='details'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='details' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Details</button>
                    <button type="button" @click="tab='instances'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='instances' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Instances</button>
                    @if(! $isDirect)
                        <button type="button" @click="tab='resellers'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='resellers' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Resellers</button>
                    @else
                        <button type="button" @click="tab='customers'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='customers' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Customers</button>
                    @endif
                    <button type="button" @click="tab='users'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='users' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Users</button>
                    <button type="button" @click="tab='billing'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='billing' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Billing</button>
                </nav>
            </div>

            <!-- Tab: Details -->
            <div x-show="tab==='details'" class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Instances (preview) -->
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

            </div>
        </div>

        <!-- Tab: Instances -->
        <div x-show="tab==='instances'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-4">
                    <div>
                        <h4 class="text-base font-semibold text-slate-900">Instances</h4>
                        <p class="mt-1 text-sm text-slate-600">All instances for this provider.</p>
                    </div>
                    <button type="button" @click="addInstanceOpen = true" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">
                        <x-icon.plus /> Add instance
                    </button>
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
                                                <a href="{{ route('instances.edit', $instance->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                                                    <x-icon.edit /> Edit
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
        </div>

        <!-- Tab: Resellers or Customers (conditional) -->
        @if(! $isDirect)
            <div x-show="tab==='resellers'" x-cloak class="mt-6">
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Resellers</h4>
                        <p class="mt-1 text-sm text-slate-600">Resellers belonging to this provider.</p>
                    </div>
                    <div class="px-6 py-4">
                        @if($resellersAll->count() === 0)
                            <div class="py-10 text-center text-sm text-slate-600">No resellers found.</div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Company</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Country</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($resellersAll as $r)
                                            <tr class="hover:bg-slate-50/60">
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                                    <a class="hover:text-primary-700" href="{{ $r->format()['path'] ?? '#' }}">{{ $r->company_name }}</a>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ $r->country->name ?? '—' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ ucwords(trans_choice($r->status->name ?? 'messages.active', 1)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div x-show="tab==='customers'" x-cloak class="mt-6">
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Customers</h4>
                        <p class="mt-1 text-sm text-slate-600">Customers buying directly from this provider.</p>
                    </div>
                    <div class="px-6 py-4">
                        @if($directCustomers->count() === 0)
                            <div class="py-10 text-center text-sm text-slate-600">No customers found.</div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Company</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Country</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($directCustomers as $c)
                                            <tr class="hover:bg-slate-50/60">
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                                    <a class="hover:text-primary-700" href="{{ $c->format()['path'] ?? '#' }}">{{ $c->company_name }}</a>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ $c->country->name ?? '—' }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ ucwords(trans_choice($c->status->name ?? 'messages.active', 1)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Tab: Users -->
        <div x-show="tab==='users'" x-cloak class="mt-6">
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

        <!-- Tab: Users -->
        <div x-show="tab==='users'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Users</h4>
                    <p class="mt-1 text-sm text-slate-600">Users assigned to this provider.</p>
                </div>
                <div class="px-6 py-4">
                    @php($users = $provider->users)
                    @if($users->count() === 0)
                        <div class="py-10 text-center text-sm text-slate-600">No users found.</div>
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

        <!-- Tab: Users -->
        <div x-show="tab==='users'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Users</h4>
                    <p class="mt-1 text-sm text-slate-600">Users assigned to this provider.</p>
                </div>
                <div class="px-6 py-4">
                    @php($users = $provider->users)
                    @if($users->count() === 0)
                        <div class="py-10 text-center text-sm text-slate-600">No users found.</div>
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

        <!-- Tab: Billing placeholder -->
        <div x-show="tab==='billing'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Billing</h4>
                    <p class="mt-1 text-sm text-slate-600">Stripe-like billing view (coming soon).</p>
                </div>
                <div class="px-6 py-10 text-center text-sm text-slate-600">
                    Billing will appear here.
                </div>
            </div>
        </div>
    </div>

    {{-- Add instance drawer (provider context) --}}
    <div x-data="{ partnerType: @js(old('external_type', 'direct_reseller')), showTokenWarning: false }">
        <div x-cloak x-show="addInstanceOpen" class="fixed inset-0 z-50" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-slate-900/30" @click="addInstanceOpen = false" aria-hidden="true"></div>

            <div class="absolute inset-y-0 right-0 flex w-full sm:max-w-2xl">
                <div class="flex h-full w-full flex-col bg-slate-50 shadow-xl">

                    <div class="sticky top-0 z-10 border-b border-slate-200 bg-slate-50/95 backdrop-blur px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-slate-500">Providers / <span class="text-slate-900">{{ $provider->company_name }}</span></div>
                                <h2 class="mt-1 truncate text-2xl font-semibold text-slate-900">Add instance</h2>
                                <p class="mt-1 text-sm text-slate-600">Connect a Microsoft Partner Center tenant to this provider.</p>
                            </div>
                            <button type="button" @click="addInstanceOpen = false" class="shrink-0 inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-white hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('instances.store') }}" class="flex h-full flex-col">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                        <div class="flex-1 overflow-y-auto px-6 py-6">
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                <div class="px-6 py-5">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Instance details</h3>

                                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Name <span class="text-rose-600">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Portugal Market" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            <p class="mt-1 text-xs text-slate-400">A friendly name to identify this connection.</p>
                                        </div>

                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Provider</label>
                                            <div class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                                <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary-100">
                                                    <span class="text-xs font-bold text-primary-700">{{ strtoupper(substr($provider->company_name ?? 'P', 0, 1)) }}</span>
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700">{{ $provider->company_name }}</span>
                                                <span class="ml-auto inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-500">locked</span>
                                            </div>
                                            <p class="mt-1 text-xs text-slate-400">Instances are always scoped to the owning provider.</p>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tenant ID <span class="text-rose-600">*</span></label>
                                            <input type="text" name="tenant_id" value="{{ old('tenant_id') }}" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            <p class="mt-1 text-xs text-slate-400">The Entra tenant ID of the Partner Center account.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-slate-100"></div>

                                <div class="px-6 py-5">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Partner type</h3>
                                    <p class="mt-1 text-xs text-slate-500">Choose how this instance transacts with Microsoft.</p>

                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <button type="button" @click="partnerType='direct_reseller'" class="text-left rounded-xl border-2 p-4 transition-all" :class="partnerType === 'direct_reseller' ? 'border-primary-500 bg-primary-50' : 'border-slate-200 bg-white hover:border-slate-300'">
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full border-2" :class="partnerType === 'direct_reseller' ? 'border-primary-500' : 'border-slate-300'">
                                                    <div class="h-2 w-2 rounded-full" :class="partnerType === 'direct_reseller' ? 'bg-primary-500' : 'bg-transparent'"></div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold" :class="partnerType === 'direct_reseller' ? 'text-primary-900' : 'text-slate-700'">Direct Provider</p>
                                                    <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Transacts directly with Microsoft. Manages own resellers and customers.</p>
                                                </div>
                                            </div>
                                        </button>

                                        <button type="button" @click="partnerType='indirect_reseller'" class="text-left rounded-xl border-2 p-4 transition-all" :class="partnerType === 'indirect_reseller' ? 'border-primary-500 bg-primary-50' : 'border-slate-200 bg-white hover:border-slate-300'">
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full border-2" :class="partnerType === 'indirect_reseller' ? 'border-primary-500' : 'border-slate-300'">
                                                    <div class="h-2 w-2 rounded-full" :class="partnerType === 'indirect_reseller' ? 'bg-primary-500' : 'bg-transparent'"></div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold" :class="partnerType === 'indirect_reseller' ? 'text-primary-900' : 'text-slate-700'">Indirect Provider</p>
                                                    <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Sells through a distributor. Resellers sell to end customers.</p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <input type="hidden" name="external_type" :value="partnerType">
                                </div>

                                <div class="border-t border-slate-100"></div>

                                <div class="px-6 py-5">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Configuration</h3>
                                    <p class="mt-1 text-xs text-slate-500">Partner Center connection settings.</p>

                                    <div class="mt-4">
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Invitation URL</label>
                                        <input type="url" name="external_url" value="{{ old('external_url') }}" placeholder="https://portal.office.com/partner/partnersignup.aspx?..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                        <p class="mt-1 text-xs text-slate-400">The admin relationship invitation link from Partner Center.</p>
                                    </div>

                                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-semibold text-amber-900">Partner Center token</p>
                                                <p class="mt-1 text-xs text-amber-700">Refreshing the token will invalidate the current Partner Center API connection. Only do this if the connection is broken or expired.</p>
                                            </div>
                                            <button type="button" @click="showTokenWarning = !showTokenWarning" class="shrink-0 rounded-lg border border-amber-300 bg-white px-3 py-2 text-xs font-semibold text-amber-900 hover:bg-amber-50">Refresh token</button>
                                        </div>

                                        <div x-show="showTokenWarning" x-cloak class="mt-3 border-t border-amber-200 pt-3">
                                            <p class="text-xs font-semibold text-amber-900">Are you sure?</p>
                                            <p class="mt-1 text-xs text-amber-800">This will disconnect active syncs until the new token is validated.</p>
                                            <div class="mt-3">
                                                <a class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-500/30" target="_blank" rel="noopener" href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=66127fdf-8259-429c-9899-6ec066ff8915&response_type=code&redirect_uri=https://partnerconsent.tagydes.com/&prompt=admin_consent">Continue to consent</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-4 text-center text-xs text-slate-400">Instances are market-scoped — products and price lists are isolated per instance.</p>
                        </div>

                        <div class="sticky bottom-0 border-t border-slate-200 bg-slate-50 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <button type="button" @click="addInstanceOpen = false" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</button>
                                <button type="submit" class="rounded-lg bg-primary-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Create instance</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
