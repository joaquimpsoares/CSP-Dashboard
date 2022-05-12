<div x-data="{ cartOpen: false , isOpen: false }" @keydown.escape.stop="cartOpen = false; focusButton()" class="z-10 flex justify-between flex-1 px-4">    @can('marketplace.index')
    <button @click="cartOpen = !cartOpen" href="#" class="p-2 bg-white rounded-md relativeblock focus:outline-none">
        @if (auth()->user()->unreadNotifications->count())
        <span class="sr-only">Notifications</span>
        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
    </button>
    @endcan
    <div x-cloak :class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 w-screen h-full max-w-2xl px-6 py-4 transition duration-300 transform bg-white border-l-2 border-gray-300">
        <div class="absolute inset-0 overflow-hidden">
            <div x-description="Background overlay, show/hide based on slide-over state." class="absolute inset-0" @click="cartOpen = !cartOpen" aria-hidden="true">
            </div>
            <div class="fixed inset-y-0 right-0 flex pl-0 sm:pl-16">
                <div x-show="open"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-2xl"
                x-description="Slide-over panel, show/hide based on slide-over state.">

                <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                    <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg text-gray-900 font-small" id="slide-over-title">
                                Cart
                            </h2>
                            <div class="flex items-center ml-3 h-7">
                                <button @click="cartOpen = !cartOpen" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" >
                                    <span class="sr-only">Close panel</span>
                                    <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @livewire('store.cart-counter')
                </div>
            </div>
        </div>
    </div>
</div>
