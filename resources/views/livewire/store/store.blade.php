<div>
    <main class="flex flex-1 overflow-hidden bg-white">
        <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
            <div class="flex-1 xl:overflow-hidden">
                <div x-data="{ open: false }" @keydown.window.escape="open = false">
                    <!-- Mobile filter dialog -->
                    <div x-show="open" class="fixed inset-0 z-40 flex lg:hidden" x-description="Off-canvas filters for mobile, show/hide based on off-canvas filters state." x-ref="dialog" aria-modal="true" style="display: none;">
                        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state." class="fixed inset-0 bg-black bg-opacity-25" @click="open = false" aria-hidden="true" style="display: none;">
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" x-description="Off-canvas menu, show/hide based on off-canvas menu state." class="relative flex flex-col w-full h-full max-w-xs py-4 pb-12 ml-auto overflow-y-auto bg-white shadow-xl" style="display: none;">
                            <div class="flex items-center justify-between px-4">
                                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                                <button type="button" class="flex items-center justify-center w-10 h-10 p-2 -mr-2 text-gray-400 bg-white rounded-md" @click="open = false">
                                    <span class="sr-only">Close menu</span>
                                    <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Filters -->
                            <form class="mt-4 border-t border-gray-200">
                                <h3 class="sr-only">Categories</h3>
                                <ul role="list" class="px-2 py-3 font-medium text-gray-900">

                                    <li>
                                        <a href="#" class="block px-2 py-3">
                                            Totes
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-2 py-3">
                                            Backpacks
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-2 py-3">
                                            Travel Bags
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-2 py-3">
                                            Hip Bags
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-2 py-3">
                                            Laptop Sleeves
                                        </a>
                                    </li>
                                </ul>
                                <div x-data="{ open: false }" class="px-4 py-6 border-t border-gray-200">
                                    <h3 class="flow-root -mx-2 -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full px-2 py-3 text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-mobile-0" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                Color
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state.Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-mobile-0" x-show="open" style="display: none;">
                                        <div class="space-y-6">

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-0" name="color[]" value="white" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-0" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    White
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-1" name="color[]" value="beige" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-1" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    Beige
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-2" name="color[]" value="blue" type="checkbox" checked="" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-2" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    Blue
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-3" name="color[]" value="brown" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-3" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    Brown
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-4" name="color[]" value="green" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-4" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    Green
                                                </label>
                                            </div>

                                            <div class="flex items-center">
                                                <input id="filter-mobile-color-5" name="color[]" value="purple" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-color-5" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    Purple
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ open: false }" class="px-4 py-6 border-t border-gray-200">
                                    <h3 class="flow-root -mx-2 -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full px-2 py-3 text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-mobile-1" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                Category
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state. Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-mobile-1" x-show="open" style="display: none;">
                                        <div class="space-y-6">
                                            @foreach($vendors as $key => $value)
                                            <div class="flex items-center">
                                                <input id="filter-mobile-category-0" name="category[]" value="new-arrivals" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-category-0" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    {{$value}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ open: false }" class="px-4 py-6 border-t border-gray-200">
                                    <h3 class="flow-root -mx-2 -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full px-2 py-3 text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-mobile-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                Size
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state. Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-mobile-2" x-show="open" style="display: none;">
                                        <div class="space-y-6">
                                            @foreach($producttype as $key => $value)
                                            <div class="flex items-center">
                                                <input id="filter-mobile-size-0" name="size[]" value="2l" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-size-0" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    {{$value}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <main class="px-4 mx-auto sm:px-6 lg:px-8"  x-data="{'layout': 'grid'}">
                    <div class="relative flex items-baseline justify-between pt-24 pb-6 border-b border-gray-200">
                        <div class="text-sm font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            {{-- <input type="text" name="search" id="search" class="block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-9 sm:text-sm" placeholder="Search">
                            <input wire:model="search" type="text" name="email" id="email"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm lg:mr-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Microsoft 365 Essentials..."> --}}
                            <div class="w-full max-w-lg ml-3 lg:max-w-xs">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative text-gray-400 focus-within:text-gray-500">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <!-- Heroicon name: solid/search -->
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                </div>
                            </div>
                        </div>
                        <div class="z-10 flex items-center col-span-6 sm:col-span-3">
                            <div x-data="{dropdownMenu: false}" class="block">
                                <!-- Dropdown list -->
                                <select wire:model="category" name="category" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">-- Select category --</option>
                                    @foreach($categories as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="p-2 -m-2 text-gray-400 sm:ml-7 hover:text-gray-500"  x-on:click="layout = 'grid'" x-bind:class="{'active': layout === 'grid'}" id="grid">
                                <span class="sr-only">View grid</span>
                                <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/view-grid" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button type="button" class="p-2 -m-2 text-gray-400 sm:ml-7 hover:text-gray-500" x-on:click="layout = 'list'" x-bind:class="{'active': layout === 'list'}" id="list">
                                <span class="sr-only">View list</span>
                                <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/view-grid" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 lg:hidden" @click="open = true">
                                <span class="sr-only">Filters</span>
                                <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/filter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <section aria-labelledby="products-heading" class="pt-6 pb-24">
                        <h2 id="products-heading" class="sr-only">Products</h2>
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                            <!-- Filters -->
                            <form class="hidden lg:block">
                                <h3 class="sr-only">{{ ucwords(trans_choice('messages.categories', 1)) }}</h3>
                                <ul role="list" class="pb-6 space-y-4 text-sm font-medium text-gray-900 border-b border-gray-200">

                                    @foreach($producttype as $key => $value)
                                    <li>
                                        <a wire:model="selectproducttype" href="#">
                                            {{$value}}
                                        </a>
                                    </li>
                                    @endforeach

                                </ul>
                                {{-- <div x-data="{ open: false }" class="py-6 border-b border-gray-200">
                                    <h3 class="flow-root -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full py-3 text-sm text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-0" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                Color
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state. Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-0" x-show="open" style="display: none;">
                                        <div class="space-y-4">

                                            <div class="flex items-center">
                                                <input id="filter-color-0" name="color[]" value="white" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-0" class="ml-3 text-sm text-gray-600">
                                                    White
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-color-1" name="color[]" value="beige" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-1" class="ml-3 text-sm text-gray-600">
                                                    Beige
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-color-2" name="color[]" value="blue" type="checkbox" checked="" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-2" class="ml-3 text-sm text-gray-600">
                                                    Blue
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-color-3" name="color[]" value="brown" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-3" class="ml-3 text-sm text-gray-600">
                                                    Brown
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-color-4" name="color[]" value="green" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-4" class="ml-3 text-sm text-gray-600">
                                                    Green
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-color-5" name="color[]" value="purple" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-color-5" class="ml-3 text-sm text-gray-600">
                                                    Purple
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div x-data="{ open: false }" class="py-6 border-b border-gray-200">
                                    <h3 class="flow-root -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full py-3 text-sm text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-1" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                {{ ucwords(trans_choice('messages.vendor', 1)) }}
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state. Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-1" x-show="open" style="display: none;">
                                        <div class="space-y-4">
                                            @foreach($vendors as $key => $vendor)
                                            <div class="flex items-center">
                                                <input id="filter-vendor-1" wire:model="vendor.{{$vendor}}" name="vendor[]" value={{ $vendor }} type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-vendor-1" class="ml-3 text-sm text-gray-600">
                                                    {{$vendor}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                {{-- <div x-data="{ open: false }" class="py-6 border-b border-gray-200">
                                    <h3 class="flow-root -my-3">
                                        <button type="button" x-description="Expand/collapse section button" class="flex items-center justify-between w-full py-3 text-sm text-gray-400 bg-white hover:text-gray-500" aria-controls="filter-section-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                            <span class="font-medium text-gray-900">
                                                Size
                                            </span>
                                            <span class="flex items-center ml-6">
                                                <svg class="w-5 h-5" x-description="Expand icon, show/hide based on section open state. Heroicon name: solid/plus-sm" x-show="!(open)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <svg class="w-5 h-5" x-description="Collapse icon, show/hide based on section open state. Heroicon name: solid/minus-sm" x-show="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h3>
                                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-2" x-show="open" style="display: none;">
                                        <div class="space-y-4">
                                            @foreach($producttype as $key => $value)
                                            <div class="flex items-center">
                                                <input id="filter-mobile-size-0" name="size[]" value="2l" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="filter-mobile-size-0" class="flex-1 min-w-0 ml-3 text-gray-500">
                                                    {{$value}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}
                            </form>
                            <!-- Product grid -->
                            <div class="lg:col-span-3">
                                <!-- Replace with your content -->
                                <div class="max-w-2xl px-4 mx-auto sm:px-6 lg:max-w-7xl lg:px-8" x-show="layout === 'grid'" x-cloak>
                                    <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"  >
                                        @forelse($prices as $price)
                                        <div class="" >
                                            <div class="flex flex-wrap place-items-center">
                                                <div>
                                                    <div class="relative ">
                                                        <div class="overflow-hidden bg-gray-100 rounded-lg aspect-w-4 aspect-h-3">
                                                            <img src="data:image/png;base64,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" alt="Light green canvas bag with black straps, handle, front zipper pouch, and drawstring top." class="object-cover object-center">
                                                        </div>
                                                        <div class="absolute inset-x-0 top-0 flex items-end justify-end p-4 text-white rounded-lg overfl ow-hidden h-52">
                                                            <div aria-hidden="true" class=""></div>
                                                            @if(Auth::user()->userLevel->name == "Reseller")
                                                            <div class="pl-3">
                                                                <p class="relative text-sm font-semibold ">
                                                                    {{ ucwords(trans_choice('messages.price', 1)) }}
                                                                </p>
                                                                <p class="relative text-sm font-semibold ">
                                                                    {{$price->currency. $price->msrp }}
                                                                </p>
                                                            </div>
                                                            @endif
                                                            <div class="pl-3">
                                                                <p class="relative text-sm font-semibold ">
                                                                    {{ ucwords(trans_choice('messages.reseller', 1)) }}
                                                                </p>
                                                                <p class="relative text-sm font-semibold ">
                                                                    {{$price->currency.'' .$price->price }}
                                                                </p>
                                                            </div>
                                                            <div class="pl-3">
                                                                <p class="relative text-sm font-semibold ">
                                                                    <button  wire:click="addToCart({{ $price->related_product->id }})" class="p-1 mb-1 bg-white rounded-full cursor-pointer">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 group-hover:opacity-50 opacity-70" fill="none" viewBox="0 0 24 24" stroke="black">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                        </svg>
                                                                    </button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="relative mt-4">
                                                            <h3 class="text-sm font-medium text-gray-900">{{ $price->related_product->name }}</h3>
                                                            <p class="mt-1 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($price->related_product->description, 150, $end='...') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6 text-white">
                                                        @if($price->related_product->category)
                                                        <span class="px-2 py-1 m-1 bg-indigo-500 rounded">
                                                            #{{ $price->related_product->category }}
                                                        </span>
                                                        @endif
                                                        @if($price->product->productType == 'OnlineServicesNCE')
                                                        <span class="px-2 py-1 m-1 bg-green-500 rounded">
                                                            {{$price->product->productType}}
                                                        </span>

                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        No products found
                                        @endforelse
                                    </div>
                                    <div class="flex justify-center mt-4">
                                        {!! $prices->links() !!}
                                    </div>
                                </div>
                                <div class="" x-show="layout === 'list'" x-cloak>
                                    <div class="mr-3 overflow-hidden bg-white shadow sm:rounded-md" >
                                        <ul role="list" class="mr-3 divide-y divide-gray-200">
                                            @forelse($prices as $price)
                                            <li>
                                                <a href="#" wire:click="addToCart({{ $price->related_product->id }})" class="block mr-3 hover:bg-gray-50">
                                                    <div class="px-4 py-4 sm:px-6">
                                                        <div class="flex items-center justify-between">
                                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                                {{ $price->related_product->name }}
                                                            </p>
                                                            <div class="flex flex-shrink-0 ml-2 text-white">
                                                                @if($price->related_product->category)
                                                                <span class="px-2 py-1 m-1 bg-indigo-500 rounded">
                                                                    #{{ $price->related_product->category }}
                                                                </span>
                                                                @endif

                                                                @if($price->product->productType == 'OnlineServicesNCE')
                                                                <span class="px-2 py-1 m-1 bg-indigo-500 rounded">
                                                                    #{{$price->product->productType}}
                                                                </span>

                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p class="top-0 mb-0 text-xs font-medium text-gray-800">
                                                            {{ $price->related_product->sku }}
                                                        </p>
                                                        <div class="mt-0 sm:flex sm:justify-between">
                                                            <div class="sm:flex">
                                                                <p class="flex items-center text-sm text-gray-500">
                                                                    <!-- Heroicon name: solid/users -->
                                                                    {{ \Illuminate\Support\Str::limit($price->related_product->description, 150, $end='...') }}
                                                                </p>
                                                                @if( strlen($price->related_product->description) >= 150)
                                                                <p class="flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                    Read More
                                                                </p>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                                @if(Auth::user()->userLevel->name == "Reseller")
                                                                <div class="pl-3">
                                                                    <div class="font-medium">
                                                                        {{ ucwords(trans_choice('messages.reseller', 1)) }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-600">
                                                                        {{$price->currency. $price->msrp }}
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                <div class="pl-3">
                                                                    <div class="font-medium">
                                                                        {{ ucwords(trans_choice('messages.price', 1)) }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-600">
                                                                        {{$price->currency.'' .$price->price }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            @empty
                                            No products found
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="flex justify-center mt-4">
                                        {!! $prices->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </main>
</div>
