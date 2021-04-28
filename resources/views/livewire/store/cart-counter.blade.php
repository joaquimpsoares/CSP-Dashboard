
<div>
    @if (isset($cart))
    <div class="flex mt-10 mb-3">
        <h3 class="w-2/5 text-xs font-semibold text-gray-600 uppercase">Product Details</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Quantity</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">billing cycle</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Price</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Total</h3>
    </div>
    @if (isset($carts))
    @forelse ($carts->products as $item)
    <div class="flex items-center px-6 py-2 -mx-8 hover:bg-gray-100">
        <div class="flex w-2/5"> <!-- product -->
            <div class="flex flex-col justify-between flex-grow ml-4">
                <span class="text-sm font-bold">{{$item->products}}</span>
            </div>
        </div>
        <div class="flex justify-center w-1/5">
            <button>
                <svg wire:click="decreaseQuantity('{{$item->id}}','{{ $item->qty }}')"
                    class="w-3 text-gray-600 fill-current" viewBox="0 0 448 512">
                    <path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>
            </button>
            <input class="mx-2 text-center border w-14" type="text" value="{{$item->qty}}">
            <button>
                <svg wire:click="increaseQuantity('{{$item->id}}','{{ $item->qty }}')" class="w-3 text-gray-600 fill-current"
                    viewBox="0 0 448 512">
                    <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>

            </button>
        </div>
        <div class="flex justify-center w-1/5">
            <select class="form-control block p-2 text-sm text-gray-600" wire:change="changeBilling($event.target.value, '{{$item->id}}')" >
                <option value="" selected="selected" hidden>{{ ucfirst($item->billing_cycle) }}</option>
                @foreach($item->cycle as $cycle)
                <option  value="{{$cycle}}" >{{ucfirst($cycle) }}</option>
                @endforeach
            </select>
        </div>
        <span class="w-1/5 text-sm font-semibold text-center">{{'$'.number_format($item->price, 2)}}</span>
        <span class="w-1/5 text-sm font-semibold text-center">{{'$'.number_format($item->total, 2)}}</span>
        <button wire:click="removeItem('{{ $item->id }}')"  class="ml-2 text-gray-500 focus:outline-none focus:text-gray-600">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
    @empty
    Cart is empty
    @endforelse

<h1 class="pb-8 text-2xl font-semibold border-b"></h1>
<div>
    <label class="inline-block mb-3 text-sm font-medium uppercase">Enter Your Country</label>
    <select wire:model='selectedCountry' class="block w-full p-2 text-sm text-gray-600">
        <option value="" selected disabled hidden>Choose here</option>
        @foreach($countries as $country)
        <option value="{{ $country->short_code }}">{{$country->name}}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="inline-block mb-3 text-sm font-medium uppercase">Choose shipping method</label>
    <select wire:model="shipping" class="block w-full p-2 text-sm text-gray-600">
        <option value="" selected="selected" hidden>Choose shipping</option>
        <option value="5">Regular shipping (+$5.00)</option>
        <option value="10">Fast shipping (+$10.00)</option>
        <option value="20">Extra fast shipping (+$20.00)</option>
    </select>
</div>
<div class="mt-8 border-t ">
    @if($shipping)
    <div class="flex justify-end pt-6 text-sm font-semibold uppercase">
        <span>Shipping: $</span>
        <span>{{number_format($shipping, 2)}}</span>
    </div>
    @endif
    <div class="flex justify-end pt-6 text-sm font-semibold uppercase">
        <span>Tax({{$taxRate*100}}%): $ </span>
        <span>{{number_format($taxValue, 2)}}</span>
    </div>
    <div class="flex justify-between py-6 text-sm font-semibold uppercase">
        <span>Total cost</span>
        <span>{{'$'.number_format($totalWithTax, 2)}}</span>
    </div>
    <button class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
        Checkout
    </button>
</div>
</div>
</div>

@endif
@if (isset($cart))
    @forelse ($cart->products as $item)
    <hr class="my-3">
    <div class="flex justify-between mt-4">
        <div class="flex">
            <div class="mx-3">
                <h3 class="text-sm text-gray-600">{{$item->name}}</h3>
            </div>
        </div>
        <form action="{{ route('cart.add_customer') }}" method="POST">
            @csrf
            {{ method_field('POST') }}
            <input type="hidden" name="cart" value="{{ $cart->first()->token }}">
            <button type="submit" href="{{ route('cart.add_customer') }}" class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
                Checkout
            </button>
        </form>
    </div>
    @endif
    <a href="{{ url('/' . $page='cart') }}" class="flex items-center justify-center px-3 py-2 mt-8 text-sm font-medium text-white uppercase bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
        <span>Chechout</span>
        <svg class="w-5 h-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
    </a>
</div>

