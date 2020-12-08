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
                    <a href="" data-toggle="modal" data-target="#createCustomer" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>{{ ucwords(__('messages.add_price')) }}</a>
                </div>
            </div>
        </div>

        <div id="createCustomer" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{ ucwords(trans_choice('messages.new_product', 1)) }}
                            </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form id="myForm" method="POST"  action="{{ route('priceList.store', ["priceList" => $priceList]) }}" class="col s12" id="createCustomer">
                                @method('POST')
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <label for="country">{{ucwords(trans_choice('messages.select_product', 1))}}</label>
                                            <div class="input-group mb-3">
                                                <select name="sku" class="form-control select2-show-search" data-placeholder="Choose one (with searchbox)">
                                                    <option value="">Choose...</option>
                                                    @foreach ($products as $product)
                                                    <option value="{{$product->sku}}">{{$product->id}} {{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ucwords(trans_choice('messages.Please_select_a_valid_country', 1))}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="price" class="">{{ ucwords(trans_choice('messages.price', 1)) }}</label>
                                            <input type="text" id="price" wire:model="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</label>
                                            <input type="text" wire:model="msrp" id="msrp" name="msrp" class="form-control" value="{{ old('msrp') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="product_vendor" class="">{{ ucwords(trans_choice('messages.vendor', 1)) }}</label>
                                            <input type="text" wire:model="product_vendor" id="product_vendor" name="product_vendor" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="currency">{{ ucwords(trans_choice('messages.currency', 1)) }}</label>
                                            <input type="text" wire:model="currency" id="currency" name="currency" class="form-control" value="{{ old('currency') }}">
                                        </div>
                                    </div>
                                    {{-- @include('priceList.partials.addprice') --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- modal-wrapper-demo -->
    </div>

    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.price', 2)) }}</a></h4>
    <div class="table-responsive">
        <table id="example" class="table table-bordered text-nowrap key-buttons">
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
                    <td>{{ $price->product->id }}</td>
                    <td>{{ $price->product_sku }}</td>
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

