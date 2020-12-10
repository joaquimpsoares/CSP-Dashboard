        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <form  method="POST" action="{{ "update/" . $reseller->id }}" class="col s12">
                            @method('patch')
                            @csrf
                            <h1>{{ ucwords(trans_choice('messages.reseller_form', 1)) }}</h1>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control" value="{{$reseller->company_name}}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                    <input type="text" id="nif" name="nif" class="form-control" value="{{$reseller->nif}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                    <div class="input-group">
                                        {{-- <div class="input-group-prepend">
                                            <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
                                            </label>
                                        </div> --}}
                                        <select name="country_id" id="country_id" class="form-control SlectBox" sf-validate="required" required>
                                            <option value="{{$reseller->country->id}}" selected>{{$reseller->country->name}}</option>
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
                            <input type="text" id="address_1" name="address_1" class="form-control mb-4" value="{{$reseller->address_1}}" placeholder="1234 Main St">
                            <label for="address-2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                            <input type="text" id="address_2" name="address_2" class="form-control mb-4" value="{{$reseller->address_2}}" placeholder="Appartment or numer">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="address-2" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                                    <input type="text" id="city" name="city" class="form-control mb-4" value="{{$reseller->city}}">
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="zip">{{ucwords(trans_choice('messages.state', 1))}}</label>
                                    <input name="state" type="text" class="form-control" id="zip" placeholder="" value="{{$reseller->state}}" required >
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="zip">Zip</label>
                                    <input name="postal_code" type="text" class="form-control" id="postal_code" placeholder="" value="{{$reseller->postal_code}}" required>
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                    <div class="form-group">
                                        <select name="status_id" class="form-control SlectBox" sf-validate="required">
                                            <option value="{{$reseller->status->id}}" selected>{{ucwords(trans_choice($reseller->status->name, 1))}}</option>
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

