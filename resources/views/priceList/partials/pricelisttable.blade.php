<div class="card">
    <div class="">
        <div class="card-body">
            @if(Auth::user()->userLevel->id === 3)
            <div class="md-form">
                <div style="display: flex;">
                    <div style="flex-grow: 31;">
                    </div>
                    <div>
                        <a type="submit" href="{{route('priceList.create')}}" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>{{ ucwords(__('messages.new_pricelist')) }}</a>
                    </div>
                </div>
            </div>
            @endif
            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.price_list_table', 1)) }}</a></h4>
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.description', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.reseller', 2)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($priceLists as $priceList)
                    <tr>
                        <td></td>
                        <td><a href="{{route('priceList.prices', $priceList['id']) }}">{{ $priceList['name'] }}</a></td>
                        <td>{{ $priceList['description'] }}</td>
                        <td>{{ $priceList['provider']['company_name'] ?? null }}</td>
                        <td>{{ $priceList['reseller']->count() }}</td>
                        <td>{{ $priceList['customer']->count() }}</td>
                        <td>
                            <a href="{{route('priceList.clone', $priceList['id'])}}"><i class="fa fa-clone"></i></a>
                            <a href="{{route('priceList.prices', $priceList['id']) }}"><i class="fa fa-list"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
