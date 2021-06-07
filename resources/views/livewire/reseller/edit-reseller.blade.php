<form wire:submit.prevent="save">
    <section class="dark-grey-text">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                        <x-input  wire:model="company_name" type="text" id="company_name" name="company_name" class="@error('company_name') is-invalid @enderror"></x-input>
                        @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="mb-2 col-md-6">
                        <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                        <x-input wire:model="nif" type="text" id="nif" name="nif" class="@error('nif') is-invalid @enderror"></x-input>
                        @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-md-12">
                        <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                        <div class="mb-3 input-group">
                            <select wire:model="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror" sf-validate="required">
                                <option value="{{$reseller->country->name}}">{{$reseller->country->name}}</option>
                                @foreach ($countries as $key => $country)
                                <option value="{{$key}}">{{$country}}</option>
                                @endforeach
                            </select>
                            @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <x-label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</x-label>
                    <x-input wire:model="address_1" type="text" id="address_1" name="address_1" class="@error('address_1') is-invalid @enderror" placeholder="1234 Main St"></x-input>
                    @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="mb-3">
                    <x-label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</x-label>
                    <x-input wire:model="address_2" type="text" id="address_2" name="address_2" class="@error('address_2') is-invalid @enderror" placeholder="Appartment or numer"></x-input>
                    @error('address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
                <div class="row">
                    <div class="mb-3 col-lg-4 col-md-6">
                        <x-label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                        <x-input wire:model="city" type="text" id="city" name="city" class=" mb-4 @error('city') is-invalid @enderror"></x-input>
                        @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="mb-3 col-lg-4 col-md-6">
                        <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                        <x-input wire:model="state" name="state" type="text" class="@error('state') is-invalid @enderror" id="state" placeholder=""></x-input>
                        @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="mb-3 col-lg-4 col-md-6">
                        <x-label for="zip">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                        <x-input wire:model="postal_code" name="postal_code" type="text" class="@error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" required></x-input>
                        @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-4 col-lg-4 col-md-6">
                        <x-label for="mpnid" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</x-label>
                        <x-input wire:model="mpnid" type="number" class="@error('mpnid') is-invalid @enderror"></x-input>
                        @error('mpnid')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="mb-4 col-lg-4 col-md-6">

                        <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                        <div class="mb-3 input-group">
                            <select wire:model="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror" sf-validate="required">
                                <option value="{{$reseller->priceList->name}}">{{$reseller->priceList->name}}</option>
                                @foreach ($reseller->provider->priceList as $key => $pricelist)
                                <option value="{{$key}}">{{$pricelist}}</option>
                                @endforeach
                            </select>
                            @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                        <div class="form-group">
                            <select wire:model="status" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                <option value="{{$reseller->status->id}}" selected>{{ucwords(trans_choice($reseller->status->name, 1))}}</option>
                                @foreach ($statuses  as $key => $status)
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
    <div class="mb-4 col-lg-12">
        <div class="text-center text-md-left">
            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <x-button color="red" type="submit" @click="slideOpen = !slideOpen"     >{{ ucwords(trans_choice('messages.update', 1)) }}</x-button>
            </div>
        </div>
    </div>
</form>




