<div class="table-responsive">
    <table id="tagydes_table_buttons" class="hover key-buttons" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
        <thead class="thead-dark">
            <tr>
                <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.product_sku', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.product_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.price', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.msrp' ,1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prices as $price)
            <tr>
                <td>{{ $price->id }}</td>
                <td>{{ $price->product_sku }}</td>
                <td><a href="{{ route('price.edit', $price->id)}}"> {{ $price->name }}</a></td>
                <td>{{ $price->price }}</td>
                <td>{{ $price->msrp }}</td>
                <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                    <a href="{{route('price.edit', $price['id']) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <a href="#" wire:click="remove({{ $price->id }})" class="text-red-600 hover:text-red-900">Remove</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">{{ ucwords(trans_choice('messages.empty', 2)) }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
