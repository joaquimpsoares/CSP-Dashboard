<div class="card">
    <div class="card-body">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <form  method="POST" action="/reseller/update/{{$reseller->id }}" class="col s12">
                    @method('patch')
                    @csrf
                    <h1>{{ ucwords(trans_choice('messages.reseller_form', 1)) }}</h1>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                            <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{$reseller->company_name}}">
                            @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                            <input type="text" id="nif" name="nif" class="form-control @error('nif') is-invalid @enderror" value="{{$reseller->nif}}">
                            @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                            <div class="input-group">
                                <select name="country_id" id="country_id" class="search-box @error('country') is-invalid @enderror" sf-validate="required" required>
                                    <option value="{{$reseller->country->id}}" selected>{{$reseller->country->name}}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    </div>
                    <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                    <input type="text" id="address_1" name="address_1" class="form-control mb-4 @error('address_1') is-invalid @enderror" value="{{$reseller->address_1}}" placeholder="1234 Main St">
                    @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    <label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                    <input type="text" id="address_2" name="address_2" class="form-control mb-4 @error('address_2') is-invalid @enderror" value="{{$reseller->address_2}}" placeholder="Appartment or numer">
                    @error('address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                            <input type="text" id="city" name="city" class="form-control mb-4 @error('city') is-invalid @enderror" value="{{$reseller->city}}">
                            @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="state">{{ucwords(trans_choice('messages.state', 1))}}</label>
                            <input name="state" type="text" class="form-control @error('state') is-invalid @enderror" id="state" placeholder="" value="{{$reseller->state}}" required >
                            @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="zip">Zip</label>
                            <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" value="{{$reseller->postal_code}}" required>
                            @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <label for="mpnid" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</label>
                            <input type="text" id="mpnid" name="mpnid" class="form-control mb-4 @error('mpnid') is-invalid @enderror" value="{{$reseller->mpnid}}">
                            @error('mpnid')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                            <div class="form-group">
                                <select name="status" class="form-control SlectBox @error('status') is-invalid @enderror" sf-validate="required">
                                    <option value="{{$reseller->status->id}}" selected>{{ucwords(trans_choice($reseller->status->name, 1))}}</option>
                                    @foreach ($statuses as $status)
                                    <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                    @endforeach
                                </select>
                                @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="text-center text-md-left">
                <div class="float-sm-right">
                    <a data-toggle="modal" data-target="#centralModalInfo" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                </div>
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
                                    <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
                                    <p>You are about to update reseller {{$reseller->company_name}}</p>
                                    <p>Are you sure?</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-primary">yes </button>
                                <a type="button" class="btn btn-secondary" data-dismiss="modal">No, thanks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



