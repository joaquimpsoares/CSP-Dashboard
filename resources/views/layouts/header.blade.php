
<header class="bg-white border-b">
    <nav class="flex flex-col flex-shrink-0 px-4 py-0 bg-white lg:flex-row lg:items-center">
        <div class="flex items-center justify-between lg:mr-32">
            <button class="px-2 py-1 text-white border border-white rounded opacity-50 hover:opacity-75 lg:hidden" id="navbar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="flex-grow lg:flex" id="navbar-collapse">
            <div class="flex flex-col mt-3 mb-1 lg:flex-row lg:mx-auto lg:mt-0 lg:mb-0">
            </div>
            <div class="flex my-3 lg:my-0">
                <a href="https://tagydes.com/docs" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">
                    Docs
                </a>
                @livewire('search.global-search')
                <x-database-notifications/>
                <span class="hidden w-px h-6 mx-4 bg-gray-200 lg:flex" aria-hidden="true"></span>
                @livewire('store.cart-counter')

                <!-- User menu -->
                <div class="relative ml-3" x-data="{ openUser: false }">
                    <button type="button"
                        @click="openUser = !openUser"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                        <span class="max-w-[160px] truncate">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-cloak x-show="openUser" @click.away="openUser = false"
                        class="absolute right-0 z-50 mt-2 w-48 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                        <a href="/settings/{{ Auth::user()->id }}"
                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Settings</a>
                        <a href="{{ Route('profile.showprofile',Auth::user()->id) }}"
                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
                        <div class="my-1 h-px bg-slate-200"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-50">
                                {{ ucwords(__('messages.logout')) }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
