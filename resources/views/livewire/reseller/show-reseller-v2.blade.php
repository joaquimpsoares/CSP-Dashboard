<div>
    @php
        /** @var \App\Reseller|null $reseller */
        $reseller = $reseller ?? null;
        $provider = $reseller?->provider;
        $customers = $reseller?->customers ?? collect();
        $users = $reseller?->users ?? collect();
        $instances = $provider ? \App\Instance::query()->where('provider_id', $provider->id)->get() : collect();
        $levelName = \Illuminate\Support\Facades\Auth::user()->userLevel->name ?? (\Illuminate\Support\Facades\Auth::user()->userlevel->name ?? null);
        // config('app.reseller') might be a permission string; rely on actual level name too.
        $isResellerUser = $levelName === 'Reseller' || $levelName === config('app.reseller');

        $customersCount = $customers->count();
        $usersCount = $users->count();
        $subsCount = $customers->sum(fn($c) => $c->subscriptions?->count() ?? 0);
    @endphp

    <!-- Header card (match Provider) -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ $reseller?->company_name ?? 'Reseller' }}</h2>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                        {{ ucwords(trans_choice($reseller?->status?->name ?? 'messages.active', 1)) }}
                    </span>
                </div>
                <div class="mt-1 text-sm text-slate-600">
                    Reseller ID: <span class="font-semibold text-slate-900">{{ $reseller?->id ?? '—' }}</span>
                    @if($provider)
                        <span class="text-slate-400">•</span>
                        Provider: <a class="font-semibold text-primary-700 hover:underline" href="{{ $provider->format()['path'] ?? '#' }}">{{ $provider->company_name }}</a>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @canImpersonate
                    @if(!empty($reseller?->format()['mainUser']))
                        <a href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                            <x-icon.impersonate /> Impersonate
                        </a>
                    @endif
                @endCanImpersonate

                <button type="button" wire:click="edit({{ $reseller?->id }})" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">
                    <x-icon.edit /> Edit reseller
                </button>
            </div>
        </div>

    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
        <!-- Summary cards -->
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">Customers</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $customersCount }}</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">Subscriptions</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $subsCount }}</div>
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
    </div>

    <div class="mt-6" x-data="{ tab: 'details' }">
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex flex-wrap gap-6">
                <button type="button" @click="tab='details'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='details' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Details</button>
                <button type="button" @click="tab='customers'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='customers' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Customers</button>
                <button type="button" @click="tab='users'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='users' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Users</button>
                <button type="button" @click="tab='billing'" class="border-b-2 px-1 pb-3 text-sm font-semibold" :class="tab==='billing' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">Billing</button>
            </nav>
        </div>

        <!-- Details -->
        <div x-show="tab==='details'" x-cloak class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Reseller Details</h4>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Company Name</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $reseller?->company_name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">MPN ID</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $reseller?->mpnid ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Price List</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $reseller?->priceList?->name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Country</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $reseller?->country?->name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Status</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ ucwords(trans_choice($reseller?->status?->name ?? 'messages.active', 1)) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Price List</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $reseller?->priceList?->name ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Provider Relationship</h4>
                        <p class="mt-1 text-sm text-slate-600">{{ $provider?->company_name ?? '—' }}</p>
                    </div>
                    <div class="px-6 py-4 text-sm text-slate-700">
                        @if($provider)
                            <a class="font-semibold text-primary-700 hover:underline" href="{{ $provider->format()['path'] ?? '#' }}">View provider</a>
                        @else
                            <span class="text-slate-500">No provider assigned.</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h4 class="text-base font-semibold text-slate-900">Recommendations</h4>
                        <p class="mt-1 text-sm text-slate-600">Quick tips to keep this reseller healthy.</p>
                    </div>
                    <div class="px-6 py-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="inline-flex items-center gap-2 rounded-lg bg-white px-2 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                <span class="inline-flex h-4 w-4 items-center justify-center rounded bg-slate-200"></span>
                                Recommendation
                            </div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">Keep customer pricing consistent</div>
                            <div class="mt-1 text-sm text-slate-600">Assign a default Price List for this reseller to avoid unexpected price changes.</div>
                        </div>

                        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                            <div class="inline-flex items-center gap-2 rounded-lg bg-white px-2 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                <span class="inline-flex h-4 w-4 items-center justify-center rounded bg-slate-200"></span>
                                Recommendation
                            </div>
                            <div class="mt-3 text-lg font-semibold text-slate-900">Invite customer admins</div>
                            <div class="mt-1 text-sm text-slate-600">Make sure each customer has at least one admin user to request products and manage subscriptions.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div x-show="tab==='customers'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Customers</h4>
                    <p class="mt-1 text-sm text-slate-600">Customers belonging to this reseller.</p>
                </div>
                <div class="px-6 py-4">
                    @if($customersCount === 0)
                        <div class="py-10 text-center text-sm text-slate-600">No customers found.</div>
                    @else
                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Company</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Country</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Subscriptions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @foreach($customers->take(50) as $c)
                                        <tr class="hover:bg-slate-50/60">
                                            <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                                <a class="hover:text-primary-700" href="{{ $c->format()['path'] ?? '#' }}">{{ $c->company_name }}</a>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-slate-700">{{ $c->country?->name ?? '—' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-700">{{ $c->subscriptions?->count() ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users -->
        <div x-show="tab==='users'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Users</h4>
                    <p class="mt-1 text-sm text-slate-600">Users assigned to this reseller.</p>
                </div>
                <div class="px-6 py-4">
                    @if($usersCount === 0)
                        <div class="py-10 text-center text-sm text-slate-600">No users found.</div>
                    @else
                        <div class="overflow-hidden rounded-xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @foreach($users as $u)
                                        <tr class="hover:bg-slate-50/60">
                                            <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ trim(($u->name ?? '') . ' ' . ($u->last_name ?? '')) ?: '—' }}</td>
                                            <td class="px-4 py-3 text-sm text-slate-700">{{ $u->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Instances -->
        <!-- Billing -->
        <div x-show="tab==='billing'" x-cloak class="mt-6">
            <div class="rounded-2xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h4 class="text-base font-semibold text-slate-900">Billing</h4>
                    <p class="mt-1 text-sm text-slate-600">Stripe-like billing view (coming soon).</p>
                </div>
                <div class="px-6 py-10 text-center text-sm text-slate-600">Billing will appear here.</div>
            </div>
        </div>
    </div>

    {{-- Keep existing modals/flows working (Edit, users, etc.) by including the original view below? --}}
</div>
