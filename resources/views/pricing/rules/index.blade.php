<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Pricing Rules</h2>
                <p class="mt-1 text-sm text-slate-600">Hierarchy: subscription &gt; customer &gt; reseller &gt; provider default.</p>
            </div>
            <a href="{{ route('pricing.rules.create') }}" class="inline-flex items-center rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">Create rule</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    <th class="px-3 py-2">Rule Set</th>
                                    <th class="px-3 py-2">Scope</th>
                                    <th class="px-3 py-2">Match</th>
                                    <th class="px-3 py-2">Base</th>
                                    <th class="px-3 py-2">Op</th>
                                    <th class="px-3 py-2">Value</th>
                                    <th class="px-3 py-2">Priority</th>
                                    <th class="px-3 py-2">Enabled</th>
                                    <th class="px-3 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($rules as $r)
                                    <tr class="text-sm text-slate-800">
                                        <td class="px-3 py-2">{{ $r->rule_set_id }}</td>
                                        <td class="px-3 py-2">{{ $r->scope_type }}{{ $r->scope_id ? ' #'.$r->scope_id : '' }}</td>
                                        <td class="px-3 py-2">{{ $r->match_type }}{{ $r->match_value ? ': '.$r->match_value : '' }}</td>
                                        <td class="px-3 py-2">{{ $r->base_price }}</td>
                                        <td class="px-3 py-2">{{ $r->operation }}</td>
                                        <td class="px-3 py-2">{{ $r->value }}</td>
                                        <td class="px-3 py-2">{{ $r->priority }}</td>
                                        <td class="px-3 py-2">{{ $r->enabled ? 'yes' : 'no' }}</td>
                                        <td class="px-3 py-2 text-right">
                                            <a class="text-primary-700 hover:underline" href="{{ route('pricing.rules.edit', $r->id) }}">Edit</a>
                                            <form class="inline" method="POST" action="{{ route('pricing.rules.delete', $r->id) }}" onsubmit="return confirm('Delete this rule?')">
                                                @csrf
                                                <button class="ml-3 text-red-700 hover:underline" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($rules->count() === 0)
                                    <tr><td class="px-3 py-6 text-sm text-slate-500" colspan="9">No rules yet.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 text-sm text-slate-600">
                        Note: Price list import/UI is MVP-stub. Engine already supports explainable quotes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
