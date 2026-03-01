<div style="min-height: 480px;" class="bg-gray-200">
    <div x-data="{ open: false }" @keydown.window.escape="open = false" class="flex h-screen overflow-hidden bg-gray-100">
        <div x-show="open" class="fixed inset-0 z-40 flex lg:hidden" x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog" aria-modal="true" style="display: none;">
            <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="open = false" aria-hidden="true" style="display: none;"></div>
            <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-description="Off-canvas menu, show/hide based on off-canvas menu state." class="relative flex flex-col flex-1 w-full max-w-xs pt-5 pb-4 bg-white" style="display: none;">
                <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Close button, show/hide based on off-canvas menu state." class="absolute top-0 right-0 pt-2 -mr-12" style="display: none;">
                    <button type="button" class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="open = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="w-6 h-6 text-white" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center flex-shrink-0 px-4">
                    <a class="header-brand" href="/">
                        @if(Auth::user()->userlevel->name == 'Reseller')
                        <img src="{{URL::asset(Auth::user()->reseller->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                        @endif
                        @if(Auth::user()->userlevel->name == 'Provider')
                        <img src="{{URL::asset(Auth::user()->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                        @endif
                        @if(Auth::user()->userlevel->name == 'Customer')
                        <img src="{{URL::asset(Auth::user()->customer->resellers->first()->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                        @endif
                        @if(Auth::user()->userlevel->name == "Super Admin")
                        <img src="{{URL::asset('/images/logos/tagydes.png')}}" class="w-auto h-14" alt="Tagydes logo">
                        @endif
                    </a>
                </div>
                <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()"class="relative inline-block px-3 mt-6 text-left">
                    <button type="button" class="group w-full  rounded-md px-3.5 py-2 text-sm text-left font-smalltext-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <span class="flex items-center justify-between w-full">
                            <span class="flex items-center justify-between min-w-0 space-x-3">
                                <span class="flex flex-col flex-1 min-w-0">
                                    <span class="text-sm text-gray-900 truncate font-small">{{Auth::user()->name}}</span>
                                    <span class="text-sm text-gray-500 truncate">{{Auth::user()->email}}</span>
                                </span>
                            </span>
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: solid/selector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </button>
                    <div x-cloak x-show.transition="open" @click.away="open = false" class="absolute top-0 right-0 z-40 w-48 py-2 mt-12 bg-white border border-gray-100 rounded-lg shadow-md">
                        {{-- <a href="/user/{{Auth::user()->id }}/edit" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">Edit --}}
                            <a href="/settings/{{Auth::user()->id }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">Edit
                            Profile
                        </a>
                        <a href="{{Route('profile.showprofile',Auth::user()->id)}}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                            Account Settings
                        </a>
                        <a href="#" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                            {{ ucwords(__('messages.logout')) }}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </div>
                </div>
                <div class="flex-1 h-0 mt-6 overflow-y-auto">
                    <nav class="px-2">
                        <div class="space-y-1">
                            <a href="{{route('home')}}" class="flex items-center w-full py-2 pl-2 pr-1 mt-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            @can('marketplace.index')
                            <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 mt-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.store', 2)) }}
                            </a>
                            @endcan

                            <hr class="my-2 border-t border-gray-200" aria-hidden="true">
                            @role('Super Admin|Admin')
                            <a href="{{ route('provider.index') }}"class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ ucwords(trans_choice('messages.provider', 2)) }}
                            </a>
                            @endrole
                            @can(config('app.reseller_index'))
                            <a href="{{ route('reseller.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/user-circle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.reseller', 2)) }}
                            </a>
                            @endcan
                            @can(config('app.customer_index'))
                            <a href="{{ route('customer.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/archive" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.customer', 2)) }}
                            </a>
                            @endcan
                            @can(config('app.subscription'))
                            <a href="{{ route('subscription.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.subscription', 2)) }}
                            </a>
                            @endcan
                            <a href="{{ url('/' . $page='order') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                {{ ucwords(trans_choice('messages.order', 2)) }}
                            </a>
                            <hr class="my-2 border-t border-gray-200" aria-hidden="true">
                        </div>
                        <div x-data="{ open: false }" class="space-y-1">
                            <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.analytics', 2)) }}
                                <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                    <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                </svg>
                            </button>
                            <div x-cloak  x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-1" x-show="open">
                                <a href="{{ url('/' . $page='analytics') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-600 rounded-md group pl-11 hover:text-gray-900 hover:bg-gray-50">
                                    {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                </a>
                                <a href="{{ url('/' . $page='analytics/licenses') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-600 rounded-md group pl-11 hover:text-gray-900 hover:bg-gray-50">
                                    {{ ucwords(trans_choice('messages.license_based', 1)) }}
                                </a>
                            </div>
                        </div>
                        @can('marketplace.index')
                        <a href="{{ url('/' . $page='order') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                            <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            {{ ucwords(trans_choice('messages.order', 2)) }}
                        </a>
                        <div x-data="{ open: false }" class="space-y-2">
                            <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.marketplace', 1)) }}
                                <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                    <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                </svg>
                            </button >
                            <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-1" x-show="open" style="display: none;">
                                <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    {{ ucwords(trans_choice('messages.store', 2)) }}
                                </a>

                                <a href="{{ url('/' . $page='cart') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Shopping Cart
                                </a>
                            </div>
                        </div>
                        @endcan
                        <div x-data="{ open: false }" class="space-y-1">
                            <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.setting', 2)) }}
                                <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                    <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                </svg>
                            </button>
                            <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-2" x-show="open" style="display: none;">
                                <a href="/settings/{{Auth::user()->id }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Settings
                                </a>

                                @can('marketplace.index')
                                <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Store
                                </a>
                                <a href="{{ url('/' . $page='cart') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Cart
                                </a>
                                @endcan

                                <a href="{{ url('/' . $page='analytics') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Analytics
                                </a>

                                <a href="https://tagydes.com/docs" target="_blank" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                    Docs
                                </a>

                                @can(config('app.customer_index'))
                                <a href="{{ route('pricing.price_lists.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.price_list', 2)) }}</a>
                                @endcan
                                @can(config('app.reseller_index'))
                                <a href="{{ route('product.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.product', 2)) }}</a>
                                <a href="{{ route('instances.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.instance', 2)) }}</a>
                                @endcan
                                @can(config('app.provider_index'))
                                <a href="{{ route('jobs') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.job', 2)) }}</a>
                                <a href="{{ route('jobsfailed') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.failed_job', 2)) }}</a>
                                @endcan
                                @can('users.manage')
                                <a href="{{ route('user.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user', 2)) }}</a>
                                @endcan
                                @can(config('app.provider_index'))
                                <a href="/userloginfo" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user_log_information', 2)) }}</a>
                                <a href="/logactivity" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.log_activity_information', 2)) }}</a>
                                @endcan
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!------------------------------------------------- Static sidebar for desktop ------------------------------------------>
        <div class="hidden bg-white border-r lg:flex lg:flex-shrink-0 ">
            <div class="flex flex-col w-64">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex flex-col flex-1 h-0">
                    <div class="flex items-center flex-shrink-0 h-16 px-4">
                        <a class="header-brand" href="/">
                            @if(Auth::user()->userlevel->name == 'Reseller')
                            <img src="{{URL::asset(Auth::user()->reseller->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                            @endif
                            @if(Auth::user()->userlevel->name == 'Provider')
                            <img src="{{URL::asset(Auth::user()->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                            @endif
                            @if(Auth::user()->userlevel->name == 'Customer')
                            <img src="{{URL::asset(Auth::user()->customer->resellers->first()->provider->logo)}}" class="w-auto h-14" alt="Tagydes logo">
                            @endif
                            @if(Auth::user()->userlevel->name == "Super Admin")
                            <img src="{{URL::asset('/images/logos/tagydes.png')}}" class="w-auto h-14" alt="Covido logo">
                            @endif
                        </a>
                    </div>
                    <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" class="relative inline-block px-3 mt-6 text-left">
                        <button type="button" class="group w-full  rounded-md px-3.5 py-2 text-sm text-left font-smalltext-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                            <span class="flex items-center justify-between w-full">
                                <span class="flex items-center justify-between min-w-0 space-x-3">
                                    <span class="flex flex-col flex-1 min-w-0">
                                        <span class="text-sm text-gray-900 truncate font-small">{{Auth::user()->name}}</span>
                                        <span class="text-sm text-gray-500 truncate">{{Auth::user()->email}}</span>
                                    </span>
                                </span>
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: solid/selector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-cloak x-show.transition="open" @click.away="open = false" class="absolute top-0 right-0 z-40 w-48 py-2 mt-12 bg-white border border-gray-100 rounded-lg shadow-md">
                            <a href="/settings/{{Auth::user()->id }}"  class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">

                            {{-- <a href="/settings/{{Auth::user()->id }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600"> --}}
                                <svg class="w-6 h-6 mr-2 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.general_settings', 2)) }}
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:bg-gray-50 hover:text-gray-900 group focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                <svg class="w-6 h-6 mr-2 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ ucwords(__('messages.logout')) }}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 mt-10 overflow-y-auto">
                        <nav class="px-2">
                            <div class="space-y-1">
                                <a href="{{route('home')}}" class="flex items-center w-full py-2 pl-2 pr-1 mt-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('home')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="w-6 h-6 mr-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>

                                @can('marketplace.index')
                                <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 mt-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('store.*')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.store', 2)) }}
                                </a>
                                @endcan

                                <hr class="my-2 border-t border-gray-200" aria-hidden="true">
                                @role('Super Admin|Admin')
                                <a href="{{ route('provider.index') }}"class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('provider.index')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.provider', 2)) }}
                                </a>
                                @endrole
                                @can(config('app.reseller_index'))
                                <a href="{{ route('reseller.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('reseller.index')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/user-circle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.reseller', 2)) }}
                                </a>
                                @endcan
                                @can(config('app.customer_index'))
                                <a href="{{ route('customer.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('customer.index')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/archive" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.customer', 2)) }}
                                </a>
                                @endcan
                                @can(config('app.subscription'))
                                <a href="{{ route('subscription.index') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('subscription.index')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.subscription', 2)) }}
                                </a>
                                @endcan
                                <a href="{{ url('/' . $page='order') }}" class="flex items-center w-full py-2 pl-2 pr-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->routeIs('order.index')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    {{ ucwords(trans_choice('messages.order', 2)) }}
                                </a>
                                <hr class="my-2 border-t border-gray-200" aria-hidden="true">
                            </div>
                            {{-- Store moved to top-level navigation (below Dashboard) --}}
                            {{-- <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ ucwords(trans_choice('messages.store', 2)) }}
                            </a>
                            <div x-data="{ open: {{ request()->is('cart*') ? 'true' : 'false' }} }" class="space-y-2">
                                <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->is('pricing/price-lists*')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.marketplace', 1)) }}
                                    <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                    </svg>
                                </button    >
                                <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-1" x-show="open" style="display: none;">
                                    <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        {{ ucwords(trans_choice('messages.store', 2)) }}
                                    </a>
                                    <a href="{{ url('/' . $page='cart') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Shopping Cart
                                    </a>
                                </div>
                            </div> --}}
                            <div x-data="{ open: {{ request()->is('analytics*') ? 'true' : 'false' }} }" class="space-y-1">
                                <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mt-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->is('analytics*')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500" x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.analytics', 2)) }}
                                    <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                    </svg>
                                </button>
                                <div x-cloak  x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-1" x-show="open">
                                    <a href="{{ url('/' . $page='analytics') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-600 rounded-md group pl-11 hover:text-gray-900 hover:bg-gray-50">
                                        {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                    </a>
                                    <a href="{{ url('/' . $page='analytics/licenses') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-600 rounded-md group pl-11 hover:text-gray-900 hover:bg-gray-50">
                                        {{ ucwords(trans_choice('messages.license_based', 1)) }}
                                    </a>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="space-y-1">
                                <button type="button" class="flex items-center w-full py-2 pl-2 pr-1 mb-1 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-indigo-500 @if(request()->is('pricing/price-lists*')) text-indigo-500 @endif focus:outline-none focus:ring-2 focus:ring-indigo-500 x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-1" @click="open = !open" aria-expanded="true" x-bind:aria-expanded="open.toString()" x-state-description="Current: &quot;bg-gray-100 text-gray-900&quot;, Default: &quot;bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900&quot;">
                                    <svg class="w-6 h-6 mr-4 text-gray-400 group-hover:text-gray-600" x-state-description="undefined: &quot;text-gray-600&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-600&quot;" x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ ucwords(trans_choice('messages.setting', 2)) }}
                                    <svg class="w-5 h-5 ml-auto text-gray-400 transition-colors duration-150 ease-in-out transform rotate-90 group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                                    </svg>
                                </button>
                                <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-2" x-show="open" style="display: none;">
                                    <a href="/settings/{{Auth::user()->id }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Settings
                                    </a>

                                    @can('marketplace.index')
                                    <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Store
                                    </a>
                                    <a href="{{ url('/' . $page='cart') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Cart
                                    </a>
                                    @endcan

                                    <a href="{{ url('/' . $page='analytics') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Analytics
                                    </a>

                                    <a href="https://tagydes.com/docs" target="_blank" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50">
                                        Docs
                                    </a>

                                    @can(config('app.customer_index'))
                                    <a href="{{ route('pricing.price_lists.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.price_list', 2)) }}</a>
                                    @endcan
                                    @can(config('app.reseller_index'))
                                    <a href="{{ route('product.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.product', 2)) }}</a>
                                    <a href="{{ route('instances.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.instance', 2)) }}</a>
                                    @endcan
                                    @can(config('app.provider_index'))
                                    <a href="{{ route('jobs') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.job', 2)) }}</a>
                                    <a href="{{ route('jobsfailed') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.failed_job', 2)) }}</a>
                                    @endcan
                                    @can('users.manage')
                                    <a href="{{ route('user.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user', 2)) }}</a>
                                    @endcan
                                    @can(config('app.provider_index'))
                                    <a href="/userloginfo" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user_log_information', 2)) }}</a>
                                    <a href="/logactivity" class="flex items-center w-full py-2 pl-16 pr-2 text-sm text-gray-600 rounded-md font-small group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.log_activity_information', 2)) }}</a>
                                    @endcan
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <div class="relative z-10 flex flex-shrink-0 h-16 bg-white border-b border-gray-200 lg:hidden">
                <button type="button" class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900 lg:hidden" @click="open = true">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" x-description="Heroicon name: outline/menu-alt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
            </div>
        {{-- </div> --}}

            {{-- </div> --}}
            {{-- <div x-data="{ cartOpen: false , isOpen: false }" @keydown.escape.stop="cartOpen = false; focusButton()" class="flex justify-between flex-1 px-4">
                <div class="flex flex-1">
                </div>
                <div class="flex items-center ml-4 lg:ml-6">
                    <x-a href='https://tagydes.com/docs' target="_blank">Documentation</x-a>
                    @livewire('search.global-search')
                    <x-database-notifications/>
                    <span class="w-px h-6 mx-4 bg-gray-200 lg:mx-6" aria-hidden="true"></span>
                    <x-cart></x-cart>
                </div>
            </div> --}}




