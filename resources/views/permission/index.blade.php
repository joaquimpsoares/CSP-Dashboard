<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Permissions</h2>
            <p class="mt-1 text-sm text-slate-600">Manage role → permission assignments.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('partials.messages')

            <form method="POST" action="{{ route('permissions.save') }}" class="space-y-6">
                @csrf

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-4 flex items-center justify-between gap-4">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Roles & Permissions</div>
                            <div class="mt-0.5 text-xs text-slate-600">Tick permissions per role, then save.</div>
                        </div>

                        <a href="{{ route('permissions.create') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Permission
                        </a>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                                        @foreach ($roles as $role)
                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-600">{{ $role->name }}</th>
                                        @endforeach
                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-600">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @if (count($permissions))
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-slate-900">
                                                    <div class="font-medium">{{ $permission->display_name ?: $permission->name }}</div>
                                                    <div class="mt-0.5 text-xs text-slate-500">{{ $permission->name }}</div>
                                                </td>

                                                @foreach ($roles as $role)
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="inline-flex items-center justify-center">
                                                            <input
                                                                type="checkbox"
                                                                name="roles[{{ $role->id }}][]"
                                                                value="{{ $permission->id }}"
                                                                class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                                                                id="cb-{{ $role->id }}-{{ $permission->id }}"
                                                                @checked($role->hasPermissionTo($permission->name))
                                                            >
                                                        </div>
                                                    </td>
                                                @endforeach

                                                <td class="px-4 py-3 text-center">
                                                    <a href="{{ route('permissions.edit', $permission) }}"
                                                       class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="{{ 2 + count($roles) }}" class="px-4 py-8 text-center text-sm text-slate-600">No records found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if (count($permissions))
                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            Save Permissions
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
