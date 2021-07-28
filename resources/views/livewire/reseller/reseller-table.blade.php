<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.reseller_table', 2)) }}</h4>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex justify-center flex-1 lg:justify-end">
                                <!-- Search section -->
                                <div class="w-full max-w-lg lg:max-w-xs">
                                    <label for="search" class="sr-only">Search</label>
                                    <div class="relative text-gray-400 focus-within:text-gray-500">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <!-- Heroicon name: solid/search -->
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.export', 1)) }}
                            </a>
                        </div>
                        @if(Auth::user()->userLevel->name != 'Super Admin')
                        @can(config('app.reseller_create'))
                        <div>
                            <a href="#" wire:click="create"class="px-2 py-2 ml-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.create', 1)) }}
                            </a>
                        </div>
                        @endcan
                        @endif
                    </div>
                </div>
                <x-table :list="$resellers" :mobileColumns="['id']"
                :columns="[

                'id' => function($reseller){
                    return $reseller['path'];
                },
                'company_name' => null,
                'provider.company_name' => null,
                'mpnid' => null,
                'country' => null,
                'created_at' => null
                ]"
                :listElementActions="[
                [
                'icon' => 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJpbmxpbmUgdy01IGgtNSBtci0yIiB2aWV3Qm94PSIwIDAgMjAgMjAiIGZpbGw9ImN1cnJlbnRDb2xvciI+CjxwYXRoIGQ9Ik0xMCAxMmEyIDIgMCAxMDAtNCAyIDIgMCAwMDAgNHoiIC8+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTS40NTggMTBDMS43MzIgNS45NDMgNS41MjIgMyAxMCAzczguMjY4IDIuOTQzIDkuNTQyIDdjLTEuMjc0IDQuMDU3LTUuMDY0IDctOS41NDIgN1MxLjczMiAxNC4wNTcuNDU4IDEwek0xNCAxMGE0IDQgMCAxMS04IDAgNCA0IDAgMDE4IDB6IiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIC8+Cjwvc3ZnPg==',
                'textKey' => 'View',
                'url' => function($reseller){
                    return $reseller['path'];
                }
                ],
                [
                'icon' => 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJpbmxpbmUgdy01IGgtNSBtci0yIiB2aWV3Qm94PSIwIDAgMjAgMjAiIGZpbGw9ImN1cnJlbnRDb2xvciI+CjxwYXRoIGQ9Ik0xMy41ODYgMy41ODZhMiAyIDAgMTEyLjgyOCAyLjgyOGwtLjc5My43OTMtMi44MjgtMi44MjguNzkzLS43OTN6TTExLjM3OSA1Ljc5M0wzIDE0LjE3MlYxN2gyLjgyOGw4LjM4LTguMzc5LTIuODMtMi44Mjh6IiAvPgo8L3N2Zz4=',
                'textKey' => 'Edit', // To get the translation on the view
                'url' => function($reseller){
                    return $reseller['path'].'/edit';
                }
                ],
                [
                'icon' => 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJoLTYgdy02IiBmaWxsPSJub25lIiB2aWV3Qm94PSIwIDAgMjQgMjQiIHN0cm9rZT0iY3VycmVudENvbG9yIj4KICA8cGF0aCBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgZD0iTTEyIDExYzAgMy41MTctMS4wMDkgNi43OTktMi43NTMgOS41NzFtLTMuNDQtMi4wNGwuMDU0LS4wOUExMy45MTYgMTMuOTE2IDAgMDA4IDExYTQgNCAwIDExOCAwYzAgMS4wMTctLjA3IDIuMDE5LS4yMDMgM20tMi4xMTggNi44NDRBMjEuODggMjEuODggMCAwMDE1LjE3MSAxN20zLjgzOSAxLjEzMmMuNjQ1LTIuMjY2Ljk5LTQuNjU5Ljk5LTcuMTMyQTggOCAwIDAwOCA0LjA3TTMgMTUuMzY0Yy42NC0xLjMxOSAxLTIuOCAxLTQuMzY0IDAtMS40NTcuMzktMi44MjMgMS4wNy00IiAvPgo8L3N2Zz4=',
                'textKey' => 'Impersonate',
                'url' => function($reseller){
                    return route('impersonate', $reseller['mainUser']['id']);
                }
                ]
                ]" />
            </div>
        </div>
    </div>
    <!-- Save Transaction Modal -->
    <form wire:submit.prevent="save">
        <x-modal.slideout wire:model.defer="showEditModal">
            <x-slot name="title">New Reseller</x-slot>
            <x-slot name="content">
                <section class="dark-grey-text">
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
            </section>
        </x-slot>
        <x-slot name="footer">
            <x-a wire:click="$set('showEditModal', false)">Cancel</x-a>
            <x-button.primary type="submit">Save</x-button.primary>
        </x-slot>
    </x-modal.slideout>
</form>
</div>
