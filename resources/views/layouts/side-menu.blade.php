{{--
<header x-data="{ mobileMenuOpen : false }" class="flex flex-wrap flex-row justify-between md:items-center md:space-x-4 bg-white py-6 px-6 relative">
  <a href="#" class="block">
    <span class="sr-only">themes.dev</span>
    <img class="h-6 md:h-8" src="/images/themesdev-logo-dark.svg" alt="Themes.dev Logo" title="Themes.dev Logo">
  </a>
  <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-block md:hidden w-8 h-8 bg-gray-200 text-gray-600 p-1">
    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
  </button>
  <nav class="absolute md:relative top-16 left-0 md:top-0 z-20 md:flex flex-col md:flex-row md:space-x-6 font-semibold w-full md:w-auto bg-white shadow-md rounded-lg md:rounded-none md:shadow-none md:bg-transparent p-6 pt-0 md:p-0"
  :class="{ 'flex' : mobileMenuOpen , 'hidden' : !mobileMenuOpen}"  @click.away="mobileMenuOpen = false"
  >
    <a href="#" class="block py-1 text-indigo-600 hover:underline">Home</a>
    <a href="#" class="block py-1 text-gray-600 hover:underline">About us</a>
    <a href="#" class="block py-1 text-gray-600 hover:underline">Services</a>
    <a href="#" class="block py-1 text-gray-600 hover:underline">Blog</a>
    <a href="#" class="block py-1 text-gray-600 hover:underline">Contact</a>
  </nav>
</header> --}}


<div  x-data="{ mobileMenuOpen : false }"  class="flex h-screen bg-gray-100" style="min-height: 640px;">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow pt-3 pb-4 overflow-y-auto bg-white border-r border-gray-200">
            <div class="flex items-center flex-shrink-0 px-5">
                <a class="header-brand" href="/">
                    @if(Auth::user()->userlevel->name == 'Reseller')
                    <img src="{{URL::asset(Auth::user()->reseller->provider->logo)}}" class="w-auto h-8" alt="Tagydes logo">
                    @endif
                    @if(Auth::user()->userlevel->name == 'Provider')
                    <img src="{{URL::asset(Auth::user()->provider->logo)}}" class="w-auto h-8" alt="Tagydes logo">
                    @endif
                    @if(Auth::user()->userlevel->name == 'Customer')
                    <img src="{{URL::asset(Auth::user()->customer->resellers->first()->provider->logo)}}" class="w-auto h-8" alt="Tagydes logo">
                    @endif
                    @if(Auth::user()->userlevel->name == "Super Admin")
                    <img src="{{URL::asset('/images/logos/tagydes.png')}}" class="w-auto h-8" alt="Covido logo">
                    <img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Tagydes logo">
                    @endif
                </a>
            </div>
            <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block px-3 mt-6 text-left">
                <button type="button" class="group w-full  rounded-md px-3.5 py-2 text-sm text-left font-medium
                text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                <span class="flex items-center justify-between w-full">
                    <span class="flex items-center justify-between min-w-0 space-x-3">
                        <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full" src="{{Auth::user()->avatar}}" alt="">
                        <span class="flex flex-col flex-1 min-w-0">
                            <span class="text-sm font-medium text-gray-900 truncate">{{Auth::user()->name}}</span>
                            <span class="text-sm text-gray-500 truncate">{{Auth::user()->email}}</span>
                        </span>
                    </span>
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: solid/selector" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </span>
            </button>
            <div x-cloak x-show.transition="open" @click.away="open = false" class="absolute top-0 right-0 z-40 w-48 py-2 mt-12 bg-white border border-gray-100 rounded-lg shadow-md">
                <a href="/user/{{Auth::user()->id }}/edit" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">Edit
                    Profile
                </a>
                <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">Account
                    Settings
                </a>
                <a href="#" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    {{ ucwords(__('messages.logout')) }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
        <div class="flex flex-col flex-grow mt-5">
            <nav class="flex-1 px-2 space-y-1 bg-white" aria-label="Sidebar">
                <div>
                    <a href="{{route('home')}}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </div>
                <hr>
                @can(config('app.provider_index'))
                <div>
                    <a href="{{ route('provider.index') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ ucwords(trans_choice('messages.provider', 2)) }}
                    </a>
                </div>
                @endcan
                @can(config('app.reseller_index'))
                <div>
                    <a href="{{ route('reseller.index') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.reseller', 2)) }}
                    </a>
                </div>
                @endcan
                @can(config('app.customer_index'))
                <div>
                    <a href="{{ route('customer.index') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.customer', 2)) }}
                    </a>
                </div>
                @endcan
                @can(config('app.subscription'))
                <div>
                    <a href="{{ route('subscription.index') }}" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.subscription', 2)) }}
                    </a>
                </div>
                @endcan
                <hr>
                <div x-data="{ open: false }" class="space-y-1">
                    <a @click="open = !open" t type="button" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7 hover:underline" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500 hover:underline" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.analytics', 2)) }}
                        <svg class="w-5 h-5 ml-auto text-gray-300 transition-colors duration-150 ease-in-out transform group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                            <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                        </svg>
                    </a>
                    <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-2" x-show="open" style="display: none;">
                        <a href="{{ url('/' . $page='analytics') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50 hover:underline">
                            {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                        </a>
                        <a href="{{ url('/' . $page='analytics/licenses') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50 hover:underline">
                            {{ ucwords(trans_choice('messages.license_based', 1)) }}
                        </a>
                    </div>
                </div>
                @can('marketplace.index')
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" type="button" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.marketplace', 1)) }}
                        <svg class="w-5 h-5 ml-auto text-gray-300 transition-colors duration-150 ease-in-out transform group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                            <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                        </svg>
                    </button>
                    <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-1" x-show="open" style="display: none;">
                        <a href="{{ route('store.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                            {{ ucwords(trans_choice('messages.store', 2)) }}
                        </a>
                        <a href="{{ url('/' . $page='order') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                            {{ ucwords(trans_choice('messages.order', 2)) }}
                        </a>
                        <a href="{{ url('/' . $page='cart') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                            Shopping Cart
                        </a>
                    </div>
                </div>
                @endcan
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" t type="button" class="flex items-center w-full py-2 pr-2 text-sm font-medium text-gray-900 rounded-md group pl-7" x-state:on="Current" x-state:off="Default" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                        <svg class="w-6 h-6 mr-3 text-gray-400 group-hover:text-gray-500" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ ucwords(trans_choice('messages.setting', 2)) }}
                        <svg class="w-5 h-5 ml-auto text-gray-300 transition-colors duration-150 ease-in-out transform group-hover:text-gray-400" viewBox="0 0 20 20" x-state:on="Expanded" x-state:off="Collapsed" aria-hidden="true" :class="{ 'text-gray-400 rotate-90': open, 'text-gray-300': !(open) }">
                            <path d="M6 6L14 10L6 14V6Z" fill="currentColor"></path>
                        </svg>
                    </button>
                    <div x-description="Expandable link section, show/hide based on state." class="space-y-1" id="sub-menu-2" x-show="open" style="display: none;">
                        @can(config('app.customer_index'))
                        <a href="{{ route('priceList.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.price_list', 2)) }}</a>
                        <a href="{{ route('product.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.product', 2)) }}</a>
                        <a href="{{ route('instances.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.instance', 2)) }}</a>
                        @endcan
                        @can(config('app.provider_index'))
                        <a href="{{ route('jobs') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.job', 2)) }}</a>
                        @endcan
                        @can('users.manage')
                        <a href="{{ route('user.index') }}" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user', 2)) }}</a>
                        @endcan
                        @can(config('app.provider_index'))
                        <a href="/userloginfo" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.user_log_information', 2)) }}</a>
                        <a href="/logactivity" class="flex items-center w-full py-2 pl-16 pr-2 text-sm font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50"> {{ ucwords(trans_choice('messages.log_activity_information', 2)) }}</a>
                        @endcan
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
