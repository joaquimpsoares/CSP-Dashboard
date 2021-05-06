<div>
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
                                    @lang('Customer Details')
                                </h5>
                                <p class="text-muted font-weight-light">
                                    @lang('Fill Customer information.')
                                </p>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="mb-4 col-md-6">
                                                <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                                <input type="text" id="company_name" wire:model="company_name" class="form-control  @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                                                @error('company_name') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                                <input wire:model="nif" type="text" id="nif" name="nif" class="form-control @error('nif') is-invalid @enderror" value="{{ old('nif') }}">
                                                @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-2 col-md-12">
                                                <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
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
                                        <label for="address_1" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                                        <input wire:model="address_1" type="text" id="address_1" name="address_1" class="form-control mb-4 @error('address_1') is-invalid @enderror" value="{{ old('address_1') }}" placeholder="1234 Main St">
                                        @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        <label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                                        <input wire:model="address_2" type="text" id="address_2" name="address_2" class="form-control mb-4 @error('address_2') is-invalid @enderror" value="{{ old('address_2') }}" placeholder="Appartment or numer">
                                        @error('address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        <div class="row">
                                            <div class="mb-4 col-lg-4 col-md-6">
                                                <label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                                                <input wire:model="city" type="text" id="city" name="city" class="form-control mb-4 @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                                @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="mb-4 col-lg-4 col-md-6">
                                                <label for="state">{{ucwords(trans_choice('messages.state', 1))}}</label>
                                                <input wire:model="state" name="state" type="text" class="form-control @error('state') is-invalid @enderror" id="state" placeholder="" value="{{ old('state') }}" required >
                                                @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="mb-4 col-lg-4 col-md-6">
                                                <label for="postal_code">Zip</label>
                                                <input wire:model="postal_code" name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" value="{{ old('postal_code') }}" required>
                                                @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
                                        {{-- <div class="form-group">
                                            <label for="name">@lang('Role')</label>
                                            {!! Form::select('role_id', $roles, $edit ? $user->roles->first()->id : '',
                                            ['class' => 'form-control input-solid', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="status">@lang('Status')</label>
                                            <select wire:model="status" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                                <option value="{{ old('status')}}" selected></option>
                                                @foreach ($statuses as $key => $status)
                                                <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                                @endforeach
                                            </select>
                                            @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">@lang('First Name')</label>
                                            <input wire:model="name" type="text" class="form-control input-solid @error('name') is-invalid @enderror" id="name" name="name" placeholder="@lang('First Name')" value="{{ old('name') }}">
                                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">@lang('Last Name')</label>
                                            <input wire:model="last_name" type="text" class="form-control input-solid @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="@lang('Last Name')" value="{{ old('last_name')  }}">
                                            @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="socialite_id">@lang('socialite_id')</label>
                                            <div class="form-group">
                                                <input wire:model="socialite_id" type="text"name="socialite_id" id='socialite_id'  value="{{ old('socialite_id') }}" class="form-control input-solid  @error('socialite_id') is-invalid @enderror" />
                                                @error('socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">@lang('Phone')</label>
                                            <input wire:model="phone" type="text" class="form-control input-solid @error('phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="@lang('Phone')" value="{{ old('phone') }}">
                                            @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address">@lang('Address')</label>
                                            <input wire:model="address" type="text" class="form-control input-solid @error('address') is-invalid @enderror" id="address"
                                            name="address" placeholder="@lang('Address')" value="{{ old('address') }}">
                                            @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="address">@lang('Country')</label>
                                            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
                                        </div> --}}
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
                                    <label for="email">@lang('Email')</label>
                                    <input wire:model="email" type="email" class="form-control input-solid @error('email') is-invalid @enderror" id="email" name="email" placeholder="@lang('Email')" value="{{ old('email') }}">
                                    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="username">@lang('Username')</label>
                                    <input type="text" class="form-control input-solid @error('username') is-invalid @enderror" id="username" placeholder="(@lang('optional'))" name="username" value="{{ $edit && $user->username ? $user->username : old('username') }}">
                                    @error('username')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                </div> --}}
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input wire:model="password" type="password" class="form-control input-solid @error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}">
                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input wire:model="password_confirmation" type="password" class="form-control input-solid @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}">
                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-lg-4">
                    <button class="btn btn-primary" type="submit">{{ucwords(trans_choice('messages.create', 1))}}</button>
                </div>
            </section>
        </div>
    </form>
</div>
