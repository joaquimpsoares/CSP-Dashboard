<div>
    {{-- $price->tiers->first()->id)}} --}}
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>{{ucwords(trans_choice('messages.tier_name', 1))}}<input wire:model="name" type="text" class="form-control" id="tier_name" placeholder="" required></th>
                <th>{{ucwords(trans_choice('messages.sku', 1))}}<input wire:model="product_sku" type="text" class="form-control" id="tier_product_sku" placeholder="" required></th>
                <th>{{ucwords(trans_choice('messages.min_quantity', 1))}}<input wire:model="min_quantity" type="number" class="form-control" id="min_quantity" placeholder="" required></th>
                <th>{{ucwords(trans_choice('messages.max_quantity', 1))}}<input wire:model="max_quantity" type="number" class="form-control" id="max_quantity" placeholder="" required></th>
                <th>{{ucwords(trans_choice('messages.price', 1))}}<input wire:model="priceU" type="number" class="form-control" id="price" placeholder="" required></th>
                <th>{{ucwords(trans_choice('messages.msrp', 1))}}<input wire:model="msrp" type="number" class="form-control" id="msrp" placeholder="" required></th>
                <th><a type="button" wire:click="update()" class="btn btn-info addrow">+</a></th>
            </tr>
        </thead>
    </div>
