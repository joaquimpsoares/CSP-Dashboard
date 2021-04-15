
<div class="row">
    <div class="col-xl-9 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="panel panel-primary">
                    <div class="p-0 tab-menu-heading bg-light">
                        <div class="tabs-menu1 ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class=""><a href="#tab5" class="active" data-toggle="tab">@lang('User Details')
                                </a></li>
                                <li><a href="#tab6" data-toggle="tab">@lang('Login Details')</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active " id="tab5" wire:ignore.self>
                                <div>
                                    @if(session()->has('message-details'))
                                    <div class="alert alert-success">
                                        {{ session('message-details') }}
                                    </div>
                                    @endif
                                </div>
                                <form wire:submit.prevent="savedetails">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="status">@lang('Status')</label>
                                                <select wire:model="status_id" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                                    @if ($edit)
                                                    <option wire:model="status_id" value="{{ $edit && $user->status->id ? $user->status->id : ''}}" selected>{{ucwords(trans_choice($user->status->name, 1))}}</option>
                                                    @endif
                                                    @foreach ($statuses as $key => $status)
                                                    <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="locale">@lang('Locale')</label>
                                                <input wire:model="locale" type="text" class="form-control input-solid @error('locale') is-invalid @enderror" id="locale"
                                                name="address" placeholder="en,es" >
                                                @error('locale')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">@lang('First Name')</label>
                                                <input wire:model="name" type="text" class="form-control input-solid @error('name') is-invalid @enderror" id="name" name="name" placeholder="@lang('First Name')"  >
                                                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">@lang('Last Name')</label>
                                                <input wire:model="last_name" type="text" class="form-control input-solid @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="@lang('Last Name')">
                                                @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phone">@lang('Phone')</label>
                                                <input wire:model="phone" type="text" class="form-control input-solid @error('phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="@lang('Phone')" >
                                                @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address">@lang('Address')</label>
                                                <input wire:model="address" type="text" class="form-control input-solid @error('address') is-invalid @enderror" id="address"
                                                name="address" placeholder="@lang('Address')" >
                                                @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="address">@lang('Country')</label>
                                                <select wire:model="country_id" name="country" class="form-control @error('country') is-invalid @enderror" sf-validate="required">
                                                    @if ($edit)
                                                    {{-- <option wire:model="country_id" value="{{ $edit && $user->country->id ? $user->country->id : ''}}" selected>{{ucwords(trans_choice($user->country->name, 1))}}</option> --}}
                                                    @endif
                                                    @foreach ($countries as $key => $country)
                                                    <option value="{{$key}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if ($edit)
                                        <div class="mt-2 col-md-12">
                                            <button type="submit" class="btn btn-primary" id="update-details-btn">
                                                <i class="fa fa-refresh"></i>
                                                @lang('Update Details')
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane " id="tab6" wire:ignore.self>
                                <div>
                                    @if(session()->has('message-auth'))
                                    <div class="alert alert-success">
                                        {{ session('message-auth') }}
                                    </div>
                                    @endif
                                </div>
                                <form wire:submit.prevent="saveauth" autocomplete="off">
                                    <div class="form-group">
                                        <label for="email">@lang('Email')</label>
                                        <div>
                                            <div class="flex mt-1 rounded-md shadow-sm">
                                                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    </div>
                                                    <input autocomplete="off" wire:model="email" type="text" name="email" id="email" class="block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm @error('email') is-invalid @enderror" id="email" placeholder="@lang('Email')" placeholder="John Doe">
                                                    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <a wire:click="sendInvitation" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z" />
                                                    </svg>
                                                    <span>Send Invitation</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <span
                                    x-data="{ isOn: false }"
                                    @click="isOn = !isOn"
                                    :aria-checked="isOn"
                                    :class="{'bg-indigo-600': isOn, 'bg-gray-200': !isOn }"
                                    class="relative flex-shrink-0 inline-block h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:shadow-outline"
                                    role="checkbox"
                                    tabindex="0"
                                    >
                                    <span
                                    aria-hidden="true"
                                    :class="{'translate-x-5': isOn, 'translate-x-0': !isOn }"
                                    class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow"
                                    ></span> --}}
                                </span>
                                <div class="form-group">
                                    <label for="password">{{ $edit ? __("New Password") : __('Password') }}</label>
                                    <input wire:model="password"  type="password" class="form-control input-solid @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" autocomplete="new-password"
                                    @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                </div>
                                <div class="form-group">
                                    <label for="password_confirm">{{ $edit ? __("Confirm New Password") : __('Confirm Password') }}</label>
                                    <input wire:model="password_confirmation" type="password" class="form-control input-solid @error('password_confirm') is-invalid @enderror" id="password_confirm" name="password_confirm"  value="{{ old('password_confirm') }}" autocomplete="new-password"
                                    @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
                                    @error('password_confirm')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="socialite_id">@lang('socialite_id')</label>
                                    <div class="form-group">
                                        <input wire:model="socialite_id" type="text" name="socialite_id"   class="form-control   @error('socialite_id') is-invalid @enderror" />
                                        @error('socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                @if ($edit)
                                <button type="submit" class="mt-2 btn btn-primary" id="update-login-details-btn">
                                    <i class="fa fa-refresh"></i>
                                    @lang('Update Details')
                                </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-lg-3">
    <div class="card box-widget widget-user">
        <div>
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
        </div>
        <div class="mx-auto mt-5 widget-user-image">
            <form wire:submit.prevent="savephoto">
                @if ($photo)
                <img alt="User Avatar" class="rounded-circle" src="{{ $photo->temporaryUrl() }}" width="128px" height="128px"></div>
                @else
                <img alt="User Avatar" class="rounded-circle" src="{{ $edit ? $user->avatar : url('assets/img/profile.png')  }}" width="128px" height="128px"></div>
                @endif
                @error('photo') <span class="error">{{ $message }}</span> @enderror
                <div class="text-center card-body">
                    <div class="pt-0 mt-0 card-body">
                        <div class="custom-file">
                            <label class="custom-file-label" for="customFileLang">Select file</label>
                            <input wire:model="photo" type="file" name="avatar" class="custom-file-input" id="customFileLang">
                        </div>
                        <div class="row">
                            <div class=" col-xs-12">
                                <h6 class="mb-4 font-weight-bold cyan-text"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="pro-user">
                        <h3 class="mb-1 pro-user-username text-dark">{{ $user->name ?? $user->email }} </h3>
                        {{-- <h6 class="pro-user-desc text-muted">{{ $user->role->first()['name'] }}</h6> --}}
                        <button type="submit" id="change-picture" class="mt-5 btn btn-outline-secondary btn-block">
                            <i class="fa fa-camera"></i> @lang('Save Photo')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
