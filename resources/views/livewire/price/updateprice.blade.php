<div>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>{{ucwords(trans_choice('messages.tier_name', 1))}}<x-input wire:model="name" type="text" class="form-control" id="tier_name" placeholder="" required></x-input></th>
                <th>{{ucwords(trans_choice('messages.sku', 1))}}<x-input wire:model="product_sku" type="text" class="form-control" id="tier_product_sku" placeholder="" required></x-input></th>
                <th>{{ucwords(trans_choice('messages.min_quantity', 1))}}<x-input wire:model="min_quantity" type="number" class="form-control" id="min_quantity" placeholder="" required></x-input></th>
                <th>{{ucwords(trans_choice('messages.max_quantity', 1))}}<input wire:model="max_quantity" type="number" class="form-control" id="max_quantity" placeholder="" required></x-input></th>
                <th>{{ucwords(trans_choice('messages.price', 1))}}<x-input wire:model="priceU" type="number" class="form-control" id="price" placeholder="" required></x-input></th>
                <th>{{ucwords(trans_choice('messages.msrp', 1))}}<x-input wire:model="msrp" type="number" class="form-control" id="msrp" placeholder="" required></x-input></th>
                <th><a type="button" wire:click="update()" class="btn btn-info addrow">+</a></th>
            </tr>
        </thead>
    </div>
