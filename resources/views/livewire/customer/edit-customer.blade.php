<form wire:submit.prevent="save">
    @if ($messageText != '')
    <div class="alert alert-info">
        {{ $messageText }}
    </div>
    @endif
    <div class="container mt-5">
        <section class="dark-grey-text">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                {{ ucwords(trans_choice('messages.edit_customer', 1)) }}
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('A general company profile information.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{$customer->company_name}}">
                                    @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-2 col-md-6">
                                    <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                    <input type="text" id="nif" name="nif" class="form-control @error('nif') is-invalid @enderror" value="{{$customer->nif}}">
                                    @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-2 col-md-12">
                                    <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                    <div class="mb-3 input-group">
                                        <select wire:model="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror" sf-validate="required">
                                            <option value="{{$customer->country->name}}">{{$customer->country->name}}</option>
                                            @foreach ($countries as $key => $country)
                                            <option value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                            <input type="text" id="address_1" name="address_1" class="form-control mb-4 @error('address_1') is-invalid @enderror" value="{{$customer->address_1}}" placeholder="1234 Main St">
                            @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            <label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                            <input type="text" id="address_2" name="address_2" class="form-control mb-4 @error('address_2') is-invalid @enderror" value="{{$customer->address_2}}" placeholder="Appartment or numer">
                            @error('address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            <div class="row">
                                <div class="mb-4 col-lg-4 col-md-6">
                                    <label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                                    <input type="text" id="city" name="city" class="form-control mb-4 @error('city') is-invalid @enderror" value="{{$customer->city}}">
                                    @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-4 col-lg-4 col-md-6">
                                    <label for="state" class="">{{ucwords(trans_choice('messages.state', 1))}}</label>
                                    <input name="state" type="text" class="form-control @error('state') is-invalid @enderror" id="state" placeholder="" value="{{$customer->state}}" required >
                                    @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-4 col-lg-4 col-md-6">
                                    <label for="city" class="">{{ucwords(trans_choice('messages.postal_code', 1))}}</label>

                                    <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" value="{{$customer->postal_code}}" required>
                                    @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                    <div class="form-group">
                                        <select wire:model="status" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                            <option value="{{$customer->status->id}}" selected>{{ucwords(trans_choice($customer->status->name, 1))}}</option>
                                            @foreach ($statuses  as $key => $status)
                                            <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                            @endforeach
                                        </select>
                                        @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="markup">{{ ucwords(trans_choice('messages.markup', 1)) }}</label>
                                    <input name="markup" type="text" class="form-control @error('markup') is-invalid @enderror" id="markup" placeholder="%" value="{{$customer->markup}}">
                                    @error('markup')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                    <div class="form-group">
                                        <select wire:model="status" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                            {{-- <option value="{{$customer->reseller}}" selected>{{$customer->resellers->company_name}}</option> --}}
                                            @foreach ($resellers  as $key => $status)
                                            <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                            @endforeach
                                        </select>
                                        @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center text-md-left">
                    <div class="float-sm-right">
                        <a data-toggle="modal" data-target="#centralModalInfo" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                    </div>
                </div>
            </div>
            <div class="mb-4 col-lg-12">
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
                                    <i class="mb-3 fa fa-check fa-4x animated rotateIn"></i>
                                    <p>You are about to update customer {{$customer->company_name}}</p>
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
        </section>
    </div>
</form>
