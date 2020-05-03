@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col">
        <h2>{{ ucwords(__('messages.products_list')) }}</h2>
    </div>
</div>


<div class="row">
    <div class="col table-responsive">
        <table class="table table-stripd ">
            <thead>
                <tr>
                    <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                </tr>
            </thead>
            <tbody>


                @forelse($carts as $cart)

                <tr class="product">
                    <td>
                        {{ $cart->customer->company_name ?? __('message.customer_not_defined') }}
                    </td>
                    <td>
                        <form action="{{ route('cart.pending_checkout') }}" method="post">
                            @csrf
    <input type="hidden" value="{{ $cart->token }}" name="token" />
                            <button type="submit"><i class="fa fa-eye"></i></button>
                        </form>

                </tr>
                @empty
                <tr>
                    <td>
                        {{  ucwords(__('messages.empty_cart')) }}
                    </td>
                </tr>
                @endforelse   

            </tbody>

        </table>
    </div>
</div>



@endsection

@section('scripts')
<script>

</script>
@endsection