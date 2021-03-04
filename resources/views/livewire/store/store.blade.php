<div>
    <div class="flex justify-between">
        <div class="flex-1">
            <div class="flex mt-1 rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model="search" type="text" name="email" id="email" class="block w-full pl-10 border-gray-300 rounded-none rounded-md focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm" placeholder="Microsoft 365 Essentials...">
                </div>
            </div>
        </div>
        <div class="ml-2">
            <select wire:model="vendor" name="vendor" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">-- Select vendor --</option>
                @foreach($vendors as $option)
                <option value="{{ $option }}">{{ Str::ucfirst($option) }}</option>
                @endforeach
            </select>
        </div>
        <div class="ml-2">
            <select wire:model="category" name="category" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">-- Select category --</option>
                @foreach($categories as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <ul class="mt-6 space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-5 lg:gap-x-8">
        @forelse($products as $product)
        <li>
            <div class="p-2 transition duration-300 transform bg-white roufnded-lg m-h-64 text-grey hover:translate-y-2 hover:shadow-xl">
                <figure class="mb-2">
                    <img src="https://cdn.worldvectorlogo.com/logos/microsoft.svg" alt="" class="h-64 ml-auto mr-auto" />
                </figure>
                <div class="flex flex-col p-4 bg-blue-500 rounded-lg opacity-90">
                    <div>
                        <h5 class="font-bold leading-none text-white md:text-xl">
                            {{ $product->name }}
                        </h5>
                        <div class="inline-flex flex-1 pt-2 items-justify ">
                            <span class="leading-none text-justify text-gray-100 md:text-xs">{{ str_limit($product->description, 150) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center flex-1 pt-6">
                        <div>
                            <div class="text-sm font-bold text-white">
                                Reseller
                                <p class="inline text-sm font-normal text-white">
                                    {{ $product->prices->price }}
                                </p>
                            </div>
                            <div class="text-sm font-bold text-white">
                                Price
                                <p class="inline text-sm font-normal text-white">
                                    {{ $product->prices->msrp }}
                                </p>
                            </div>
                        </div>
                        <a  wire:click.prevent="addToCart({{ $product->id }})" class="flex inline p-2 ml-auto text-white transition duration-300 bg-gray-800 rounded-full hover:bg-gray-500 hover:text-purple-900 hover:shadow-xl focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </li>
        @empty
        No products found
        @endforelse
    </ul>
    <div class="inline-flex items-center flex-1 pt-6">
        @if (!$products)
        <h2><strong>{{ ucwords(trans_choice('messages.no_priceList', 1)) }}</strong></h2>
        @endif
        <hr>
        <div class="col">
            <span class="float-right">
                {!! $products->links() !!}
            </span>
        </div>
    </div>
</div>

