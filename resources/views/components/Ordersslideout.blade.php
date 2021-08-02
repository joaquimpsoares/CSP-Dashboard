<div>
    <div x-data="{ slideOpen: false , isOpen: false }" @keydown.escape.stop="slideOpen = false; focusButton()" class="flex justify-between flex-1 px-4">
        <div class="flex flex-1">
        </div>
        <div class="z-50 flex items-center ml-4 lg:ml-6">
            {{-- <a  href="#" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                {{ ucwords(trans_choice('messages.edit', 1)) }}
            </a> --}}
            <a @click="slideOpen = !slideOpen"  class="dropdown-item" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit
            </a>
            <div x-cloak :class="slideOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 w-screen h-full max-w-2xl px-6 py-4 transition duration-300 transform bg-white border-l-2 border-gray-300">
                <div class="absolute inset-0 overflow-hidden">
                    <div x-description="Background overlay, show/hide based on slide-over state." class="absolute inset-0" @click="slideOpen = !slideOpen" aria-hidden="true">
                    </div>
                    <div class="fixed inset-y-0 right-0 flex pl-0 sm:pl-16">
                        <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-2xl" x-description="Slide-over panel, show/hide based on slide-over state.">
                            <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                                <div class="px-4 sm:px-6">
                                    <div class="flex items-start justify-between">
                                        <h2 class="text-lg text-gray-900 font-small" id="slide-over-title">
                                            Cart
                                        </h2>
                                        <div class="flex items-center ml-3 h-7">
                                            <button @click="slideOpen = !slideOpen" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" >
                                                <span class="sr-only">Close panel</span>
                                                <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative flex-1 px-4 mt-6 sm:px-6">
                                    <input class="form-control" type="text" name="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


