
<div>
    <div class="bg-white">
        <div class="container px-1 py-2 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-end w-full">
                        <button wire:click="open" class="relative text-gray-700 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="absolute inset-0 object-left-top -mr-7">
                                <div class="inline-flex items-center px-1.5 py-0.1 border-2 border-white rounded-full text-xs font-semibold leading-4 bg-red-500 text-white">
                                    @if (isset($cart))
                                    {{$cart->products->count( )}}
                                    @endif
                                </div>
                            </span>
                        </button>
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
                <a href="{{ url('/' . $page='cart') }}" class="flex items-center justify-center px-3 py-2 mt-8 text-sm font-medium text-white uppercase bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                    <span>Chechout</span>
                    <svg class="w-5 h-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
