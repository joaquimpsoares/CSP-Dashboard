<div>
    <div class="col">
        <div class="product-quantity">
            {{-- <form wire:submit.prevent='changeProductQuantity'> --}}
                <input wire:model="quantity" type="number" value="{{ $productspivot->quantity }}" name="{{ $productspivot->id }}" id="quantity"
                class="form-control" step="1" min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}" style="max-width: 10em;" required />
            {{-- </form> --}}
        </div>
    </div>
</div>
