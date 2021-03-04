
<div>
    <div class="bg-white">
        <div class="container px-6 py-3 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-end w-full">
                        <button wire:click="open" class="relative px-1 py-4 text-gray-800 transition duration-150 ease-in-out border-2 border-transparent rounded-full hover:text-gray-400 focus:outline-none focus:text-gray-500" aria-label="Cart">
                            <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            <span class="absolute inset-0 object-right-top -mr-6">
                                <div class="inline-flex items-center px-1.5 py-0.5 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                                    6
                                </div>
                            </span>
                        </button>
                        {{-- <div class="flex sm:hidden">
                            <button type="button" class="text-gray-600 hover:text-gray-500 focus:outline-none focus:text-gray-500" aria-label="toggle menu">
                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                                    <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                                </svg>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div :class="$cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="@if (!$cartOpen) hidden @endif fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-medium text-gray-700">Your cart</h3>
                        <button wire:click="close" class="text-gray-600 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    @if (isset($cart))
                    @forelse ($cart->products as $item)
                    <hr class="my-3">
                    <div class="flex justify-between mt-4">
                        <div class="flex">
                            <div class="mx-3">
                                <h3 class="text-sm text-gray-600">{{$item->name}}</h3>
                            </div>
                        </div>
                        <span class="text-gray-600">{{$item->prices->price}}€</span>
                        <button wire:click="removeItem('{{ $item->pivot->id }}')"  class="ml-2 text-gray-500 focus:outline-none focus:text-gray-600">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    @empty
                    Cart is empty
                    @endforelse
                    @endif
                    <a class="flex items-center justify-center px-3 py-2 mt-8 text-sm font-medium text-white uppercase bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                        <span>Chechout</span>
                        <svg class="w-5 h-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
