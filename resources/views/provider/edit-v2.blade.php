<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Edit provider</h2>
                <p class="mt-1 text-sm text-slate-600">Update company details for <span class="font-semibold text-slate-900">{{ $provider->company_name }}</span>.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('provider.show', $provider->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl space-y-6 sm:px-6 lg:px-8">

            @if(session('message'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('message') }}
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

            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-slate-900">Provider details</h3>
                    <p class="mt-1 text-sm text-slate-600">Basic company data used across the platform.</p>
                </div>

                <form method="POST" action="{{ route('provider.update', $provider->id) }}" class="px-6 py-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-700" for="company_name">Company name</label>
                            <input id="company_name" name="company_name" type="text" value="{{ old('company_name', $provider->company_name) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700" for="nif">NIF</label>
                            <input id="nif" name="nif" type="text" value="{{ old('nif', $provider->nif) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700" for="country_id">Country</label>
                            <select id="country_id" name="country_id"
                                    class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                                <option value="" disabled>—</option>
                                @foreach($countries as $id => $name)
                                    <option value="{{ $id }}" @selected((int)old('country_id', $provider->country_id) === (int)$id)>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-700" for="address_1">Address 1</label>
                            <input id="address_1" name="address_1" type="text" value="{{ old('address_1', $provider->address_1) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-slate-700" for="address_2">Address 2 (optional)</label>
                            <input id="address_2" name="address_2" type="text" value="{{ old('address_2', $provider->address_2) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700" for="city">City</label>
                            <input id="city" name="city" type="text" value="{{ old('city', $provider->city) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700" for="state">State</label>
                            <input id="state" name="state" type="text" value="{{ old('state', $provider->state) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700" for="postal_code">Postal code</label>
                            <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $provider->postal_code) }}"
                                   class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-200 pt-6">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
