
<div>
    @if (isset($cart))
    <div class="flex mt-10 mb-3">
        <h3 class="w-2/5 text-xs font-semibold text-gray-600 uppercase">Product Details</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Quantity</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Price</h3>
        <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">Total</h3>
    </div>
    @forelse ($cart as $key => $item)

    <div class="flex items-center px-6 py-2 -mx-8 hover:bg-gray-100">
        <div class="flex w-2/5"> <!-- product -->
            <div class="flex flex-col justify-between flex-grow ml-4">
                <span class="text-sm font-bold">{{$item->product_name}}
                    @if($item->addon == true)
                    <x-tooltip>These add-ons require a compatible base product subscription to work. Expand the description for more information.</x-tooltip>
                    @endif
                </span>
                {{-- @dd($item) --}}
            </div>
        </div>
        <div class="flex justify-center w-1/5">
            <button>
                <svg wire:click="decreaseQuantity('{{$item->id}}','{{ $item->qty }}')"
                    class="w-3 text-gray-600 fill-current" viewBox="0 0 448 512">
                    <path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>
            </button>
            <input wire:change="changeQty($event.target.value, '{{$item->id}}')" value={{$item->qty}} class="mx-2 text-sm text-center border rounded-sm w-14 focus:outline-none" type="text" >
            <button>
                <svg wire:click="increaseQuantity('{{$item->id}}','{{ $item->qty }}')" class="w-3 text-gray-600 fill-current"
                    viewBox="0 0 448 512">
                    <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                </svg>

            </button>
        </div>
        @if($item->productType == 'OnlineServicesNCE')
        <div class="flex justify-center w-1/5 font-bold">
            <span class="text-xs font-bold">
                {{$item->term_duration}}/{{$item->billing_cycle}}
            </span>
        </div>

        @else
        {{-- <div class="flex justify-center w-1/5 ml-3">
            <select name="terms[{{$key}}][billingCycle" class="form-control" wire:change.defer="selectBilling($event.target.value, '{{$item->id}}')" name="terms" class="block w-full p-2 text-sm text-gray-600 form-control"  required>
                @foreach ($billing_cycle as $key => $billing)
                <option  value="{{ $billing['billingCycle'] }}">{{ $billing['billingCycle']}}</option>
                @endforeach
            </select>
        </div> --}}
        <div class="flex justify-center w-1/5">
            <select class="block p-2 text-sm text-gray-600 form-control" wire:change="changeBilling($event.target.value, '{{$item->id}}')" >
                <option value="" selected="selected" hidden>{{ ucfirst($item->billing_cycle) }}</option>
                @foreach($item->cycle as $cycle)
                <option  value="{{$cycle}}" >{{ucfirst($cycle) }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <span class="w-1/5 text-sm font-semibold text-center">{{'$'.number_format($item->price, 2)}}</span>
        <button wire:click="removeItem('{{ $item->id }}')"  class="ml-2 text-gray-500 focus:outline-none focus:text-gray-600">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
    @empty
    Cart is empty
    @endforelse
    {{-- @dd(Auth::user()->userLevel) --}}
    @if(Auth::user()->userLevel->name == 'Customer')
    @php
    $customer = Auth::user()->customer;
    @endphp
    @else
    <h1 class="pb-8 text-2xl font-semibold border-b"></h1>
    <div >
        <label class="inline-block mb-3 text-sm font-medium uppercase">Choose customer</label>
        <select class="block w-full p-2 text-sm text-gray-600 form-control" wire:change="setCustomer($event.target.value, '{{$item->id}}')" >
            <option value="" selected disabled hidden>Choose here</option>
            @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{$customer->company_name}}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="mt-8 border-t ">
        <div class="flex justify-between py-6 text-sm font-semibold uppercase">
            <span>Total cost</span>
            <span>{{'$'.number_format($totalCartWithoutTax, 2)}}</span>
        </div>
        <form action="{{ route('cart.add_customer') }}" method="POST">
            @csrf
            {{ method_field('POST') }}
            @if(Auth::user()->userLevel->name == 'Customer')
            <input type="hidden"  name="cart" value="{{ $cart->first()->token }}">
            <button type="submit"  class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
                Checkout
            </button>
            @else
            <input type="hidden" name="cart" value="{{ $cart->first()->token }}">
            <button type="submit" class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
                Checkout
            </button>
            @endif
        </form>
    </div>
    @endif
</div>
