
<div class="row">
    @include('layouts.messages')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Azure analytics</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 border table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.estimated_cost', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.budget', 1)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.budget_used%', 1)) }}<i class="mr-1 fa fa-arrow-up"></i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resourceName as $index => $item)
                            <tr>
                                <td class="d-flex"><a href="{{ $item->customer->format()['path'] }}">{{$item->customer['company_name']}}</a></td>
                                <td>{{$item->name}}</td>
                                @php
                                $percentage =($item->customer['markup']/100)*$item->azureresources->sum('cost');
                                $markup = $percentage+$item->azureresources->sum('cost');
                                @endphp
                                <td>{{$item->customer->country->currency_symbol}}@money($markup)</td>
                                <td>

                                    @if ($editedProductIndex === $index || $editedProductField === $index . '.name')
                                    <div>
                                    <input type="text"
                                    @click.away="$wire.editedProductField === '{{ $index }}.budget' ? $wire.saveBudget({{ $index }}) : null"
                                    wire:model.defer="resourceName.{{ $index }}.budget"
                                    class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border w-full py-2 focus:outline-none focus:border-blue-400 {{ $errors->has('products.' . $index . '.budget') ? 'border-red-500' : 'border-gray-400' }}"
                                    />
                                </div>
                                    <div class="text-red-500" wire:loading>
                                        Processing request...
                                    </div>
                                    @if ($errors->has('products.' . $index . '.budget'))
                                    <div class="text-red-500">{{ $errors->first('products.' . $index . '.budget') }}</div>
                                    @endif
                                    @else
                                    <div class="cursor-pointer" wire:click="editProductField({{ $index }}, 'name')">
                                        {{ $item->customer->country->currency_symbol}}@money($item->budget)
                                    </div>
                                    @endif
                                </td>

                                <td>
                                    @if (($item->calculated/100) < '0.50')
                                    <div class="mx-auto mb-0 chart-circle chart-circle-xs chart-circle-primary mt-sm-0 icon-dropshadow-primary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#4454c3">
                                        @else
                                        <div class="mx-auto mb-0 chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 icon-dropshadow-secondary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#f72d66">
                                            @endif
                                            <div class="mx-auto text-center chart-circle-value">{{(int)($item->calculated)}}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- <x-a color="gray" href="/analytics/update/{{$item->customer_id}}/{{$item->id}}">Update</x-a> --}}
                                        <x-a color="blue" href="/analytics/details/{{$item->customer_id}}/{{$item->id}}">View Details</x-a>
                                        @if($editedProductIndex === $index || (isset($editedProductField) && (int)(explode('.',$editedProductField)[0])===$index))
                                        <x-button wire:loading.attr="disabled" color="gray" wire:click.prevent="saveBudget({{$index}})">Save Budget</x-button>
                                        @else
                                        <x-button  wire:loading.attr="disabled" color="gray" wire:click.prevent="editProduct({{$index}})">Edit Budget</x-button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right card-footer d-flex">
                            @if ($resourceName->total() >= '10')
                            {{ $resourceName->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

