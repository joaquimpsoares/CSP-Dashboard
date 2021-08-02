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
                                @lang('Reseller Details')
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('Fill Reseller information.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                                            <x-input type="text" id="company_name" wire:model="company_name" class=" @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}"></x-input>
                                            @error('company_name') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                                            <x-input wire:model="nif" type="text" id="nif" name="nif" class="@error('nif') is-invalid @enderror" value="{{ old('nif') }}"></x-input>
                                            @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-md-12">
                                            <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                            <div class="mb-3 input-group">
                                                <select wire:model="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror" sf-validate="required">
                                                    <option value="">Choose...</option>
                                                    @foreach ($countries as $key => $country)
                                                    <option value="{{$key}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <x-label for="address_1" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</x-label>
                                    <x-input wire:model="address_1" type="text" id="address_1" name="address_1" class="mb-4 @error('address_1') is-invalid @enderror" value="{{ old('address_1') }}" placeholder="1234 Main St"></x-input>
                                    @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    <x-label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</x-label>
                                    <x-input wire:model="address_2" type="text" id="address_2" name="address_2" class="mb-4 @error('address_2') is-invalid @enderror" value="{{ old('address_2') }}" placeholder="Appartment or numer"></x-input>
                                    @error('address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    <div class="row">
                                        <div class="mb-4 col-lg-4 col-md-6">
                                            <x-label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                            <x-input wire:model="city" type="text" id="city" name="city" class="mb-4 @error('city') is-invalid @enderror" value="{{ old('city') }}"></x-input>
                                            @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="mb-4 col-lg-4 col-md-6">
                                            <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                            <x-input wire:model="state" name="state" type="text" class="@error('state') is-invalid @enderror" id="state" placeholder="" value="{{ old('state') }}" required ></x-input>
                                            @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="mb-4 col-lg-4 col-md-6">
                                            <x-label for="postal_code">Zip</x-label>
                                            <x-input wire:model="postal_code" name="postal_code" type="text" class="@error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" value="{{ old('postal_code') }}" required></x-input>
                                            @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="mb-4 col-lg-4 col-md-6">
                                            <x-label for="mpnid" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</x-label>
                                            <x-input wire:model="mpnid" type="number" id="mpnid" name="mpnid" class="mb-4 no-spin @error('mpnid') is-invalid @enderror" min="4" value="{{ old('mpnid') }}"></x-input>
                                            @error('mpnid')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                @lang('User Details')
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('A general user profile information.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="status">@lang('Status')</x-label>
                                        <select wire:model="status" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                            <option value="{{ old('status')}}" selected></option>
                                            @foreach ($statuses as $key => $status)
                                            <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                            @endforeach
                                        </select>
                                        @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <x-label for="name">@lang('First Name')</x-label>
                                        <x-input wire:model="name" type="text" class="@error('name') is-invalid @enderror" id="name" name="name" placeholder="First Name" value="{{ old('name') }}"></x-input>
                                        @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <x-label for="last_name">@lang('Last Name')</x-label>
                                        <x-input wire:model="last_name" type="text" class="@error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name')  }}"></x-input>
                                        @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-label for="socialite_id">@lang('socialite_id')</x-label>
                                        <div class="form-group">
                                            <x-input wire:model="socialite_id" class="@error('socialite_id') is-invalid @enderror" type="text" name="socialite_id" id='socialite_id' value="{{ old('socialite_id') }}"></x-input>
                                            @error('socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <x-label for="phone">@lang('Phone')</x-label>
                                        <x-input wire:model="phone" type="text" class="@error('phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="Phone" value="{{ old('phone') }}"></x-input>
                                        @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <x-label for="address">@lang('Address')</x-label>
                                        <x-input wire:model="address" type="text" class="@error('address') is-invalid @enderror" id="address"
                                        name="address" placeholder="Address" value="{{ old('address') }}"></x-input>
                                        @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                @lang('Login Details')
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('Details used for authenticating with the application.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <x-label for="email">@lang('Email')</x-label>
                                <x-input wire:model="email" type="email" class="@error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}"></x-input>
                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                            </div>
                            <div class="form-group">
                                <x-label for="password">{{ __('Password') }}</x-label>
                                <x-input wire:model="password" type="password" class="@error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}"></x-input>
                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="form-group">
                                <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
                                <x-input wire:model="password_confirmation" type="password" class="@error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"></x-input>
                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" type="submit">{{ucwords(trans_choice('messages.create', 1))}}</button>
                </div>
            </div>
        </section>
    </div>
</form>
