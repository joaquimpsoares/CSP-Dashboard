<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">{{ $mode === 'edit' ? 'Edit rule' : 'Create rule' }}</h2>
            <p class="mt-1 text-sm text-slate-600">Rules apply within active rule sets. Higher priority + higher specificity wins.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    <form method="POST" action="{{ $mode === 'edit' ? route('pricing.rules.update', $rule->id) : route('pricing.rules.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">Rule set</label>
                                <select name="rule_set_id" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach($ruleSets as $rs)
                                        <option value="{{ $rs->id }}" @selected(old('rule_set_id', $rule->rule_set_id) == $rs->id)>{{ $rs->name }} (prio {{ $rs->priority }})</option>
                                    @endforeach
                                </select>
                                @error('rule_set_id')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Scope type</label>
                                <select name="scope_type" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach(['provider_default','reseller','customer','subscription'] as $s)
                                        <option value="{{ $s }}" @selected(old('scope_type', $rule->scope_type) == $s)>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('scope_type')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Scope id (nullable for provider_default)</label>
                                <input name="scope_id" value="{{ old('scope_id', $rule->scope_id) }}" class="mt-1 w-full rounded-lg border-slate-300" />
                                @error('scope_id')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Match type</label>
                                <select name="match_type" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach(['all','offer','sku','meter','category','product_family','tag'] as $m)
                                        <option value="{{ $m }}" @selected(old('match_type', $rule->match_type) == $m)>{{ $m }}</option>
                                    @endforeach
                                </select>
                                @error('match_type')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Match value</label>
                                <input name="match_value" value="{{ old('match_value', $rule->match_value) }}" class="mt-1 w-full rounded-lg border-slate-300" />
                                @error('match_value')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Base price</label>
                                <select name="base_price" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach(['cost','erp'] as $b)
                                        <option value="{{ $b }}" @selected(old('base_price', $rule->base_price) == $b)>{{ $b }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Operation</label>
                                <select name="operation" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach(['markup_percent','markup_fixed','discount_percent','fixed_price','tiered'] as $op)
                                        <option value="{{ $op }}" @selected(old('operation', $rule->operation) == $op)>{{ $op }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Value</label>
                                <input name="value" value="{{ old('value', $rule->value) }}" class="mt-1 w-full rounded-lg border-slate-300" />
                                @error('value')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Priority</label>
                                <input name="priority" value="{{ old('priority', $rule->priority ?? 0) }}" class="mt-1 w-full rounded-lg border-slate-300" />
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Enabled</label>
                                <select name="enabled" class="mt-1 w-full rounded-lg border-slate-300">
                                    <option value="1" @selected(old('enabled', (int)$rule->enabled) === 1)>yes</option>
                                    <option value="0" @selected(old('enabled', (int)$rule->enabled) === 0)>no</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-slate-700">Rounding mode</label>
                                <select name="rounding_mode" class="mt-1 w-full rounded-lg border-slate-300">
                                    @foreach(['none','to_cents','to_0_05','to_1'] as $rm)
                                        <option value="{{ $rm }}" @selected(old('rounding_mode', $rule->rounding_mode ?? 'to_cents') == $rm)>{{ $rm }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('pricing.rules') }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700">Cancel</a>
                            <button type="submit" class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
