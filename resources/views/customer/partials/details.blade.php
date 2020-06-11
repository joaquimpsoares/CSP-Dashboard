
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                {{-- <form  method="POST" action="{{ route('update', $customer->id) }}" class="col s12"> --}}
                    @method('patch')
                    @csrf        
                    <h1>{{ ucwords(trans_choice('messages.customer_form', 1)) }}</h1>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" value="{{$customer->company_name}}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                            <input type="text" id="nif" name="nif" class="form-control" value="{{$customer->nif}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
                                    </label>
                                </div>
                                <select name="country_id" class="custom-select" id="country_id" required>
                                    <option value="{{$customer->country->id}}" selected>{{$customer->country->name}}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ucwords(trans_choice('messages.Please_select_a_valid_country', 1))}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                    <input type="text" id="address_1" name="address_1" class="form-control mb-4" value="{{$customer->address_1}}" placeholder="1234 Main St">
                    <label for="address-2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                    <input type="text" id="address_2" name="address_2" class="form-control mb-4" value="{{$customer->address_2}}" placeholder="Appartment or numer">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="address-2" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                            <input type="text" id="city" name="city" class="form-control mb-4" value="{{$customer->city}}">
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="zip">{{ucwords(trans_choice('messages.state', 1))}}</label>
                            <input name="state" type="text" class="form-control" id="zip" placeholder="" value="{{$customer->state}}" required >
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="zip">Zip</label>
                            <input name="postal_code" type="text" class="form-control" id="postal_code" placeholder="" value="{{$customer->postal_code}}" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input name="email" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{$users}}" placeholder="youremail@example.com">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input name="username" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{$customer->nif}}" placeholder="Username (Optional)">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                            <div class="form-group">
                                <select name="status_id" class="form-select" sf-validate="required">
                                    <option value="{{$customer->status->id}}" selected>{{$customer->status->name}}</option>
                                    @foreach ($statuses as $status)    
                                    <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="text-center text-md-left">
                <a data-toggle="modal" data-target="#centralModalInfo" class="genric-btn primary">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" data-backdrop="false">
                    <div class="modal-dialog modal-notify modal-info" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="heading lead">{{ ucwords(trans_choice('messages.are_you_sure', 1)) }}</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="white-text">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                    <p>You are about to update customer {{$customer->company_name}}</p>
                                    <p>Are you sure?</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn submit_btn">yes </button>
                                <a type="button" class="genric-btn primary" data-dismiss="modal">No, thanks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




