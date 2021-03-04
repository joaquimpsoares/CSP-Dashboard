<div>
    <div class="py-12">
        <div class="max-w-md mx-auto rounded-lg shadow-lg md:max-w-7xl">
            <div class="md:flex">
                <div class="w-full p-4 px-5 py-5">
                    <div class="gap-2 md:grid md:grid-cols-3">
                        <div class="col-span-2 p-5">
                            <h1 class="text-xl font-medium">Shopping Cart</h1>
                            @forelse ($cart->products as $item)
                            <div class="flex items-center justify-between pt-6 pb-5 pr-3 hover:bg-gray-200">
                                <div class="flex items-center">
                                    <div class="flex flex-col ml-3">
                                        <span class="pr-8 font-sm md:text-md">{{$item->name}}</span>
                                        <span class="text-xs text-gray-400 font-sm md:text-mdt">{{$item->sku}}</span>
                                        <div class="flex items-center mt-2">
                                            <button class="text-gray-400 focus:outline-none focus:text-gray-700">
                                                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>

                                            <input type="number" id="company_name" name="company_name" class="h-6 px-2 mx-2 text-sm bg-gray-100 border rounded w-7 focus:outline-none  @error('company_name') is-invalid @enderror"
                                            value="{{$currentProduct}}" min="minimum_quantity"  max="{{$item->maximum_quantity}}" />
                                            @error('company_name') <span class="error">{{ $message }}</span> @enderror



                                            <button wire:click="increment('{{ $item->minimum_quantity }}')" class="text-gray-400 focus:outline-none focus:text-gray-700">
                                                <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </div>
                                        <div class="flex items-center">
                                        <span class="text-xs text-gray-400 font-sm md:text-mdt">{{$item->maximum_quantity - $item->minimum_quantity}} License(s) left</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div class="m-3">
                                        <span class="text-xs font-medium">{{$item->prices->price}} €</span>
                                    </div>
                                    <div class="m-6">
                                        <span class="text-xs font-medium">{{$item->prices->msrp}} €</span>
                                    </div>
                                    <div class="m-7">
                                        <button wire:click="removeItem('{{ $item->pivot->id }}')"  class="text-gray-500 focus:outline-none focus:text-gray-600">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            Cart is empty
                            @endforelse
                            <div class="flex items-center justify-between pt-6 mt-6 border-t">
                                <div class="flex items-center"><i class="pr-2 text-sm fa fa-arrow-left"></i>
                                    <span class="font-medium text-blue-500 text-md">Continue Shopping</span>
                                </div>
                                <div class="flex items-end justify-center">
                                    <span class="mr-1 text-sm font-medium text-gray-400">Subtotal:</span>
                                    <span class="text-lg font-bold text-gray-800"> $24.90</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 overflow-visible rounded bg-gradient-to-r from-green-400 to-green-200 ">
                            <span class="block pb-3 text-xl font-medium text-gray-100">Order Summary</span>
                            <div class="flex justify-between mt-10 mb-5">
                                <span class="text-sm font-semibold uppercase"> Item(s) {{$cart->products->count()}}</span>
                                <span class="text-sm font-semibold">590$</span>
                            </div>
                            <div class="py-10">
                                <label for="promo" class="inline-block mb-3 text-sm font-semibold uppercase">Promo Code</label>
                                <input type="text" id="promo" placeholder="Enter your code" class="w-full p-2 text-sm" />
                            </div>
                            <button class="px-5 py-2 text-sm text-white uppercase bg-red-500 hover:bg-red-600">Apply</button>
                            <div class="mt-8 border-t">
                                <div class="flex justify-between py-6 text-sm font-semibold uppercase">
                                    <span>Total cost</span>
                                    <span>$600</span>
                                </div>
                                <button class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

