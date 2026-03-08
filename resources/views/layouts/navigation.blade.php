<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/80 backdrop-blur overflow-visible">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @hasanyrole('Customer')
                        <x-nav-link :href="route('store.index')" :active="request()->routeIs('store.*')">
                            {{ __('Store') }}
                        </x-nav-link>
                    @endhasanyrole

                    @role('Super Admin|Admin')
                        <x-nav-link :href="route('provider.index')" :active="request()->routeIs('provider.*')">
                            {{ __('Providers') }}
                        </x-nav-link>
                    @endrole

                    @can(config('app.reseller_index'))
                        <x-nav-link :href="route('reseller.index')" :active="request()->routeIs('reseller.*')">
                            {{ __('Resellers') }}
                        </x-nav-link>
                    @endcan

                    @can(config('app.customer_index'))
                        <x-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.*')">
                            {{ __('Customers') }}
                        </x-nav-link>
                    @endcan

                    <x-nav-link :href="route('subscription.index')" :active="request()->routeIs('subscription.*')">
                        {{ __('Subscriptions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('order.index')" :active="request()->routeIs('order.*')">
                        {{ __('Orders') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right side: env toggle | search | cart | bell | config | profile -->
            <div class="hidden sm:flex sm:items-center sm:gap-2">

                <!-- ENV TOGGLE SLOT -->
                <x-environment-toggle />

                <!-- Global search (icon) -->
                <div class="flex items-center">
                    @livewire('search.global-search')
                </div>

                <!-- Cart icon -->
                @php
                    $cartCount = Auth::user()->cart?->products?->count() ?? 0;
                @endphp
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center rounded-lg px-2 py-1 text-sm font-medium text-slate-600 hover:text-slate-900">
                    <span class="sr-only">Cart</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-600 px-1 text-xs font-semibold leading-none text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- Notifications bell (database notifications) -->
                <div class="flex items-center">
                    <x-database-notifications />
                </div>

                @hasanyrole('Super Admin|Admin|Provider')
                <!-- Configuration mega menu -->
                <div
                    x-data="{
                        openConfig: false,
                        top: 0,
                        left: 0,
                        width: 0,
                        place() {
                            const r = this.$refs.btn.getBoundingClientRect();
                            this.width = 720;
                            this.top = r.bottom + 8;
                            // Right-align to the button but keep inside viewport.
                            const desiredLeft = r.right - this.width;
                            this.left = Math.max(8, Math.min(desiredLeft, window.innerWidth - this.width - 8));
                        },
                        toggle() {
                            this.openConfig = !this.openConfig;
                            if (this.openConfig) this.$nextTick(() => this.place());
                        }
                    }"
                    @keydown.escape.window="openConfig = false"
                    class="relative"
                >
                    <button
                        type="button"
                        x-ref="btn"
                        @click="toggle()"
                        class="inline-flex items-center gap-2 rounded-lg border border-transparent bg-transparent px-1 pt-1 text-sm font-medium leading-5 text-slate-600 hover:text-slate-900 focus:outline-none transition"
                    >
                        <span>{{ __('Configuration') }}</span>
                        <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <template x-teleport="body">
                        <div
                            x-cloak
                            x-show="openConfig"
                            @click.away="openConfig = false"
                            @scroll.window="openConfig = false"
                            @resize.window="openConfig = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="fixed z-[99999] min-w-[600px] max-w-[720px] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
                            :style="`top:${top}px; left:${left}px;`"
                        >
                            <div class="p-4">
                                <div class="grid grid-cols-3 gap-4">
                            <!-- Column 1: Manage -->
                            <div>
                                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Manage</div>
                                <div class="space-y-1">
                                    <a href="{{ route('settings', Auth::id()) }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Building office -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 21h18" />
                                                <path d="M9 8h1" />
                                                <path d="M9 12h1" />
                                                <path d="M9 16h1" />
                                                <path d="M14 8h1" />
                                                <path d="M14 12h1" />
                                                <path d="M14 16h1" />
                                                <path d="M6 21V5a2 2 0 012-2h8a2 2 0 012 2v16" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Settings</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Platform configuration</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('store.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Shopping bag -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M6 7h12l-1 14H7L6 7Z" />
                                                <path d="M9 7a3 3 0 016 0" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Store</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Storefront settings</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('priceList.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Currency euro -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 7a6 6 0 00-10.8 3" />
                                                <path d="M18 17a6 6 0 01-10.8-3" />
                                                <path d="M6 10h10" />
                                                <path d="M6 14h10" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Price Lists</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Manage pricing rules</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('product.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Cube -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4a2 2 0 001-1.73Z" />
                                                <path d="M12 22V12" />
                                                <path d="M3.3 7.3 12 12l8.7-4.7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Products</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Product catalog</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Column 2: Infrastructure -->
                            <div>
                                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Infrastructure</div>
                                <div class="space-y-1">
                                    @can(config('app.instances_index'))
                                    <a href="{{ route('instances.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Link -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M10 13a5 5 0 007.07 0l1.41-1.41a5 5 0 000-7.07 5 5 0 00-7.07 0L10 5" />
                                                <path d="M14 11a5 5 0 01-7.07 0L5.52 9.59a5 5 0 010-7.07 5 5 0 017.07 0L14 3" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Instances</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Partner Center connections</div>
                                        </div>
                                    </a>
                                    @endcan

                                    <a href="{{ route('jobs.pending') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Cog -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                                                <path d="M19.4 15a7.7 7.7 0 0 0 .1-1 7.7 7.7 0 0 0-.1-1l2-1.5-2-3.5-2.4 1a8 8 0 0 0-1.7-1l-.3-2.6H9l-.3 2.6a8 8 0 0 0-1.7 1l-2.4-1-2 3.5 2 1.5a7.7 7.7 0 0 0-.1 1c0 .3 0 .7.1 1l-2 1.5 2 3.5 2.4-1c.5.4 1.1.7 1.7 1l.3 2.6h6l.3-2.6c.6-.3 1.2-.6 1.7-1l2.4 1 2-3.5-2-1.5Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Jobs</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Background job queue</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('jobsfailed') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- X circle -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                                                <path d="m15 9-6 6" />
                                                <path d="m9 9 6 6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Failed Jobs</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Review failed jobs</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Column 3: Access & Logs -->
                            <div>
                                <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Access & Logs</div>
                                <div class="space-y-1">
                                    <a href="{{ route('user.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Users -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                                <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Users</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Manage platform users</div>
                                        </div>
                                    </a>

                                    @can('permissions.manage')
                                    <a href="{{ route('permissions.index') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Shield / key -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                                                <path d="M9 12l2 2 4-4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Permissions</div>
                                            <div class="mt-0.5 text-xs text-slate-600">Roles & access control</div>
                                        </div>
                                    </a>
                                    @endcan

                                    <a href="{{ route('userloginfo') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Clipboard -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 5H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                                                <path d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" />
                                                <path d="M9 5h6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">User Logs</div>
                                            <div class="mt-0.5 text-xs text-slate-600">User activity records</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('logactivity') }}" class="group flex gap-3 rounded-xl p-3 hover:bg-slate-50">
                                        <div class="mt-0.5 text-slate-500 group-hover:text-slate-700">
                                            <!-- Chart bar -->
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 3v18h18" />
                                                <path d="M18 17V9" />
                                                <path d="M13 17V5" />
                                                <path d="M8 17v-3" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Log Activity</div>
                                            <div class="mt-0.5 text-xs text-slate-600">System activity log</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
                @endhasanyrole

                <!-- Profile dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 transition">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.showprofile', Auth::id())">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.notifications', Auth::id())">
                            {{ __('Notifications settings') }}
                        </x-dropdown-link>

                        <div class="my-1 h-px bg-slate-200"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @can(config('app.instances_index'))
                <x-responsive-nav-link :href="route('instances.index')" :active="request()->routeIs('instances.*')">
                    {{ __('Instances') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
