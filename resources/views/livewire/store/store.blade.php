<div>
    <div class="flex justify-between">
        <div class="flex-1">
            <div class="mt-1 flex rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model="search" type="text" name="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Microsoft 365 Essentials...">
                </div>
            </div>
        </div>
        <div class="ml-2">
            <select wire:model="vendor" name="vendor" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">-- Select vendor --</option>
                @foreach($vendors as $option)
                <option value="{{ $option }}">{{ Str::ucfirst($option) }}</option>
                @endforeach
            </select>
        </div>
        <div class="ml-2">
            <select wire:model="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">-- Select category --</option>
                @foreach($categories as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <ul class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-5 lg:gap-x-8 mt-6">
        @forelse($products as $product)
        <li>
            <div class="bg-white roufnded-lg m-h-64 p-2 text-grey transform hover:translate-y-2 hover:shadow-xl transition duration-300">
                <figure class="mb-2">
                    <img src="https://cdn.worldvectorlogo.com/logos/microsoft.svg" alt="" class="h-64 ml-auto mr-auto" />
                </figure>
                <div class="rounded-lg p-4 bg-blue-500 opacity-90 flex flex-col">
                    <div>
                        <h5 class="text-white md:text-xl font-bold leading-none">
                            {{ $product->name }}
                        </h5>
                        <div class="pt-2 flex-1 inline-flex items-justify   ">
                            <span class="md:text-xs text-gray-100  leading-none text-justify">{{ str_limit($product->description, 150) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 pt-6 flex items-center">
                        <div>
                            <div class="text-sm text-white font-bold">
                                Reseller
                                <p class="text-sm inline text-white font-normal">
                                    {{ $product->prices->price }}
                                </p>
                            </div>
                            <div class="text-sm text-white font-bold">
                                Price
                                <p class="text-sm inline text-white font-normal">
                                    {{ $product->prices->msrp }}
                                </p>
                            </div>
                        </div>
                        <a  wire:click.prevent="addToCart({{ $product->id }})" class="p-2 inline rounded-full bg-gray-800 text-white hover:bg-white hover:text-purple-900 hover:shadow-xl focus:outline-none flex ml-auto transition duration-300">
                            <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </li>
        @empty
        No products found
        @endforelse
    </ul>
    <div class="pt-6 flex-1 inline-flex items-center">
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

    <!--Toast-->
    <div @if (!$showModal) hidden @endif class="alert-toast fixed top-12 right-0 m-8 w-5/6 md:w-full max-w-sm">
        <input type="checkbox" class="hidden" id="footertoast">
        <div wire:click="close" class=" cursor-pointer flex items-start justify-between w-full p-2 bg-green-700 h-24 rounded text-white" title="close" for="footertoast">
            <div class="sm:text-left text-center sm:mb-0 mb-3 w-128">
                <p class=" mb-1 text-lg">{{ session('success') }}</p>
            </div>
            <div class="sm:text-left text-center sm:mb-0 mb-3 w-128">
                <p class=" mb-1 text-lg">{{ session('success') }}</p>
            </div>
        </label>
        <a href="/cart" class="btn btn-primary" >{{ucwords(trans_choice('messages.cart', 1))}}</a>
    </div>
</div>
