<div class="p-6">
    <div class="flex flex-col gap-4">
        <div class="flex flex-col items-start justify-between gap-3 lg:flex-row lg:items-center">
            <div>
                <h4 class="text-base font-semibold text-slate-900">Price Lists</h4>
                <p class="mt-1 text-sm text-slate-600">Manage price lists and jump into pricing details.</p>
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative text-gray-400 focus-within:text-gray-500">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live="filters.search" id="search" class="block w-full rounded-lg border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" placeholder="Search price lists" type="search" name="search">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" wire:click="exportSelected" onclick="confirm('Export selected price lists?') || event.stopImmediatePropagation()"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                        Export
                    </button>

                    <button type="button" wire:click="$toggle('showDeleteModal')"
                        class="inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700 shadow-sm hover:bg-rose-100 focus:outline-none focus:ring-4 focus:ring-rose-500/20">
                        Delete
                    </button>

                    <button type="button" wire:click="create"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                        New
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">All</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['all'] ?? 0 }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Provider lists</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['provider'] ?? 0 }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Reseller lists</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['reseller'] ?? 0 }}</div>
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-visible rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 bg-white">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="w-10 px-3 py-2">
                            <x-input.checkbox wire:model="selectPage" />
                        </th>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Owner</th>
                        <th class="px-3 py-2">Updated</th>
                        <th class="px-3 py-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if ($selectPage)
                        <tr class="bg-slate-50">
                            <td class="px-3 py-3" colspan="6">
                                @unless ($selectAll)
                                    <span class="text-sm text-slate-700">You have selected <strong>{{ $priceLists->count() }}</strong> items. Select all <strong>{{ $priceLists->total() }}</strong>?</span>
                                    <button type="button" wire:click="selectAll" class="ml-2 text-sm font-semibold text-primary-700 hover:text-primary-800">Select all</button>
                                @else
                                    <span class="text-sm text-slate-700">You are selecting all <strong>{{ $priceLists->total() }}</strong> items.</span>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @forelse ($priceLists as $pl)
                        <tr class="text-sm text-slate-800">
                            <td class="px-3 py-2">
                                <x-input.checkbox wire:model="selected" value="{{ $pl->id }}" />
                            </td>
                            <td class="px-3 py-2">
                                <a href="{{ route('priceList.show', $pl->id) }}" class="font-semibold text-slate-900 hover:text-primary-700">
                                    {{ $pl->name }}
                                </a>
                                <div class="text-xs text-slate-500">ID: {{ $pl->id }}</div>
                            </td>
                            <td class="px-3 py-2 text-xs text-slate-600">{{ $pl->description ?? '—' }}</td>
                            <td class="px-3 py-2 text-xs text-slate-600">
                                @if($pl->provider_id)
                                    Provider: <span class="font-semibold">{{ $pl->provider->company_name ?? $pl->provider_id }}</span>
                                @elseif($pl->reseller_id)
                                    Reseller: <span class="font-semibold">{{ $pl->reseller->company_name ?? $pl->reseller_id }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-3 py-2 text-xs text-slate-600">{{ optional($pl->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-3 py-2 text-right">
                                <a href="{{ route('priceList.show', $pl->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Open</a>
                                <button type="button" wire:click="edit({{ $pl->id }})" class="ml-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-10 text-sm text-slate-500" colspan="6">No price lists found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $priceLists->links() }}
        </div>

        <!-- Delete Modal (kept as-is) -->
        <form wire:submit.prevent="deleteSelected">
            <x-modal.confirmation wire:model.defer="showDeleteModal">
                <x-slot name="title">Delete price lists</x-slot>
                <x-slot name="content">
                    <div class="py-4 text-slate-700">Are you sure? This action is irreversible.</div>
                </x-slot>
                <x-slot name="footer">
                    <button type="submit" class="inline-flex justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-700">Delete</button>
                    <button type="button" wire:click="$set('showDeleteModal', false)" class="ml-2 inline-flex justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                </x-slot>
            </x-modal.confirmation>
        </form>

        <!-- Edit/New Modal (kept, but will still use existing components) -->
        <form wire:submit.prevent="save">
            <x-modal.dialog wire:model.defer="showEditModal">
                <x-slot name="title">{{ ucwords(trans_choice('messages.edit', 1)) }}</x-slot>
                <x-slot name="content">
                    <x-input.group for="instance_id" label="Instance" :error="$errors->first('editing.instance_id')">
                        <x-input.select wire:model="editing.instance_id" id="instance_id">
                            <option value="">Select instance...</option>
                            @foreach ($instances as $instance)
                                <option value="{{ $instance->id }}">{{ $instance->name }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="name" label="{{ ucwords(trans_choice('messages.name', 1)) }}" :error="$errors->first('editing.name')">
                        <x-input.text wire:model="editing.name" id="name" placeholder="name" />
                    </x-input.group>

                    <x-input.group for="description" label="{{ ucwords(trans_choice('messages.description', 1)) }}" :error="$errors->first('editing.description')">
                        <x-input.text wire:model="editing.description" id="description" placeholder="description" />
                    </x-input.group>

                    <x-input.group for="margin" label="{{ ucwords(trans_choice('messages.margin', 1)) }}" :error="$errors->first('editing.margin')">
                        <x-input.text wire:model="editing.margin" id="margin" placeholder="margin" />
                    </x-input.group>
                </x-slot>
                <x-slot name="footer">
                    <button type="submit" class="inline-flex justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">Save</button>
                    <button type="button" wire:click="$set('showEditModal', false)" class="ml-2 inline-flex justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                </x-slot>
            </x-modal.dialog>
        </form>
    </div>
</div>
