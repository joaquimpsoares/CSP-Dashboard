<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Edit instance</h2>
                <p class="mt-1 text-sm text-slate-600">
                    {{ $instance->name }}
                    <span class="text-slate-400">•</span>
                    <span class="font-medium text-slate-700">{{ $instance->type ?? '—' }}</span>
                    @if(method_exists($instance, 'isExpired') && $instance->isExpired())
                        <span class="ml-2 inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Expired</span>
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('instances.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                    Back
                </a>

                @if(($instance->type ?? '') === 'Microsoft')
                    <a href="{{ route('instances.getMasterToken', $instance->id) }}" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                        <x-icon.refresh />
                        Refresh master token
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    {{ session('warning') }}
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <div class="font-semibold">Please fix the errors below:</div>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main form -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-900">Details</h3>
                            <p class="mt-1 text-sm text-slate-600">Update instance settings.</p>
                        </div>

                        <form method="POST" action="{{ route('instances.update', $instance->id) }}" class="px-6 py-6">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="name">Name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $instance->name) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="type">Type</label>
                                    <input id="type" type="text" value="{{ $instance->type ?? '' }}" disabled
                                           class="mt-1 block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="tenant_id">Tenant ID</label>
                                    <input id="tenant_id" name="tenant_id" type="text" value="{{ old('tenant_id', $instance->tenant_id) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="external_type">CSP mode</label>

                                    @php($et = old('external_type', $instance->external_type))
                                    @php($locked = !empty($instance->external_type))

                                    @if($locked)
                                        <input type="hidden" name="external_type" value="{{ $et }}">
                                    @endif

                                    <select id="external_type" name="external_type" @disabled($locked)
                                            class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200">
                                        <option value="direct" @selected($et === 'direct')>Direct (no resellers; purchase on behalf of customers)</option>
                                        <option value="indirect" @selected($et === 'indirect')>Indirect (resellers + customers)</option>
                                    </select>

                                    <p class="mt-1 text-xs text-slate-500">
                                        @if($locked)
                                            Locked once defined.
                                        @else
                                            Choose carefully: once set, it cannot be changed later.
                                        @endif
                                    </p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700" for="external_url">External URL</label>
                                    <input id="external_url" name="external_url" type="text" value="{{ old('external_url', $instance->external_url) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                @if(($instance->type ?? '') === 'kaspersky')
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700" for="certificate">Certificate</label>
                                        <textarea id="certificate" name="certificate" rows="8"
                                                  class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 font-mono text-xs text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20"
                                                  placeholder="Paste certificate here">{{ old('certificate', $certificate ?? '') }}</textarea>
                                        <p class="mt-1 text-xs text-slate-500">Stored encrypted in DB.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-200 pt-6">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                    Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-900">Status</h3>
                            <p class="mt-1 text-sm text-slate-600">Quick metadata.</p>
                        </div>
                        <div class="space-y-3 px-6 py-6 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">ID</span>
                                <span class="font-medium text-slate-900">{{ $instance->id }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Provider</span>
                                <span class="font-medium text-slate-900">{{ $instance->provider->company_name ?? $instance->provider->name ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Token updated</span>
                                <span class="font-medium text-slate-900">{{ optional($instance->external_token_updated_at)->format('Y-m-d H:i') ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Expires</span>
                                <span class="font-medium text-slate-900">{{ optional($instance->expires_at)->format('Y-m-d') ?? '—' }}</span>
                            </div>

                            @if(isset($expiration))
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Token expiration (est.)</span>
                                    <span class="font-medium text-slate-900">{{ optional($expiration)->format('Y-m-d') ?? '—' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
