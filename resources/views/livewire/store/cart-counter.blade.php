
<div>

    <div class="relative flex-1 px-4 mt-6 sm:px-6">
        @if (isset($cart))
        <div class="flex mt-10 mb-3">
            <h3 class="w-2/5 text-xs font-semibold text-gray-600 uppercase">{{ ucwords(trans_choice('messages.name', 1)) }}</h3>
            <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">{{ ucwords(trans_choice('messages.quantity', 1)) }}</h3>
            <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</h3>
            <h3 class="w-1/5 text-xs font-semibold text-center text-gray-600 uppercase">{{ ucwords(trans_choice('messages.price', 1)) }}</h3>
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
            @elseif($item->cycle->first() == 'one_time')
            <div class="flex justify-center w-1/5">
                <span class="text-xs font-bold">
                    {{$item->cycle->first()}}
                </span>
            </div>
            @else
            <div class="flex justify-center w-1/5">
                <select wire:model="billing_cycle" class="block p-2 text-sm text-gray-600 form-control @error('billing_cycle') is-invalid @enderror" sf-validate="required" wire:change="changeBilling($event.target.value, '{{$item->id}}')" required >
                    <option value="" selected="selected" hidden>{{ ucwords(trans_choice('messages.select_one', 1)) }}</option>
                    @foreach($item->cycle as $cycle)
                    <option  value="{{$cycle}}" >{{ucfirst($cycle) }}</option>
                    @endforeach
                </select>
                @error('billing_cycle')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
            <label class="inline-block mb-3 text-sm font-medium uppercase">{{ ucwords(trans_choice('messages.choose_customer', 1)) }}</label>
            <select wire:model="company_name" class="block w-full p-2 text-sm text-gray-600 form-control @error('billing_cycle') is-invalid @enderror" wire:change="setCustomer($event.target.value, '{{$item->id}}')" required >
                <option value="" selected hidden>{{ ucwords(trans_choice('messages.select_one', 1)) }}</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{$customer->company_name}}</option>
                @endforeach
            </select>
            @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        @endif
        <div class="flex justify-between py-6 text-sm font-semibold uppercase">
            <span>{{ ucwords(trans_choice('messages.total_cost', 1)) }}</span>
            <span>{{'$'.number_format($totalCartWithoutTax, 2)}}</span>
        </div>
        <input type="hidden"  name="cart" value="{{ $cart->first()->token }}">
        <button wire:click="checkout" class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
            {{ ucwords(trans_choice('messages.checkout', 1)) }}
        </button>
        {{-- <div class="mt-8 border-t ">
            <div class="flex justify-between py-6 text-sm font-semibold uppercase">
                <span>{{ ucwords(trans_choice('messages.total_cost', 1)) }}</span>
                <span>{{'$'.number_format($totalCartWithoutTax, 2)}}</span>
            </div>
            <form action="{{ route('cart.add_customer') }}" method="POST">
                @csrf
                {{ method_field('POST') }}
                @if(Auth::user()->userLevel->name == 'Customer')
                <input type="hidden"  name="cart" value="{{ $cart->first()->token }}">
                <button type="submit"  class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
                    {{ ucwords(trans_choice('messages.checkout', 1)) }}
                </button>
                @else
                <input type="hidden" name="cart" value="{{ $cart->first()->token }}">
                <button type="submit" class="w-full py-3 text-sm font-semibold text-white uppercase bg-indigo-500 hover:bg-indigo-600">
                    {{ ucwords(trans_choice('messages.checkout', 1)) }}
                </button>
                @endif
            </form>
        </div> --}}
        @else
        <table class="wrapper" width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td align="center" class="sm-px-12" width="100%">
                <table class="sm-w-full" width="600" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td align="center" style="padding-top: 64px; padding-bottom: 64px;">
                      <img src="https://res.cloudinary.com/maizzle/image/upload/v1541500690/remix/deal-shop/cart-hero.png" width="93" style="border: 0; line-height: 100%; vertical-align: middle;" alt>
                      <h2 class="all-font-montserrat" style="margin-bottom: 4px; margin-top: 24px; color: #4a5568; font-size: 20px;">Your shopping cart is empty</h2>
                      <p class="all-font-sans" style="margin: 0; margin-bottom: 24px; color: #718096; font-size: 16px;">Check back the store.</p>
                      <table cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                          <th class="hover-bg-dealshop-blue-dark" style="mso-padding-alt: 16px 40px; border-radius: 9999px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06);" bgcolor="#4285f4">
                            <a href="/store" class="all-font-montserrat" style="display: block; font-weight: 600; line-height: 100%; padding-top: 16px; padding-bottom: 16px; padding-left: 40px; padding-right: 40px; color: #ffffff; font-size: 14px; text-decoration: none;">Return to Shop</a>
                          </th>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        @endif

    </div>
    {{-- </div>
    </div>
</div>
</div>
</div> --}}
