<div class="container">
	<div class="card">
		<div class="card-body">

			{{-- @if(Auth::user()->userLevel->id === 4) --}}
			<div class="md-form">
				<div style="display: flex;">
					<div style="flex-grow: 31;">
					</div>
					<div>
						{{-- <form method="post" enctype="multipart/form-data" action="{{ url('/pricelist/import') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                    <tr>
                                        <td width="40%" align="right"><label>Select File for Upload</label></td>
                                        <td width="30">
                                            <input type="file" name="select_file" />
                                        </td>
                                        <td width="30%" align="left">
                                            <input type="submit" name="upload" class="btn submit_btn" value="Upload">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="right"></td>
                                        <td width="30"><span class="text-muted">.xls, .xslx</span></td>
                                        <td width="30%" align="left"></td>
                                    </tr>
                                </table>
                            </div>
                        </form> --}}
						<a type="submit" href="" data-toggle="modal" data-target="#createCustomer" class="btn submit_btn">{{ ucwords(__('messages.add_price')) }}</a>
					</div>
				</div>
			</div>

			<div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<form method="POST" action="{{ route('priceList.store', ["priceList" => $priceList]) }}" class="col s12" id="createCustomer">
							@method('POST')
							@csrf
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">
									{{ ucwords(trans_choice('messages.new_product', 1)) }}
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								@include('priceList.partials.addprice')
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			{{-- @endif --}}
			<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.price', 2)) }}</a></h4>
			<table class="table table-hover" id="example">
				<thead class="thead-dark">
					<tr>
						<th></th>
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
						<td></td>
						<td	>{{ $price->product->id }}</td>
						<td	>{{ $price->product_sku }}</td>
						<td><a href="{{ route('price.edit', $price->id)}}"> {{ $price->name }}</a></td>
						<td>{{ $price->price }}</td>
						<td>{{ $price->msrp }}</td>
						<td>{{ ucwords(trans_choice('messages.action', 2)) }}</td>
					</tr>					
					@empty
					<tr>
						<td colspan="5">{{ ucwords(trans_choice('messages.empty', 2)) }}</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>