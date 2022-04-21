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
                            <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">

                            {{-- <a href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"> --}}
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
                <x-tableazure>
                    <x-slot name="head">
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.id', 2)) }}</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('company_name')"  :direction="$sorts['company_name'] ?? null">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-table.heading>
                        <x-table.heading multi-column wire:click="sortBy('provider')"  :direction="$sorts['provider'] ?? null">{{ ucwords(trans_choice('messages.relationship', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('mpnid')"         :direction="$sorts['mpnid'] ?? null">{{ ucwords(trans_choice('messages.mpnid', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('country_id')"       :direction="$sorts['country_id'] ?? null">{{ ucwords(trans_choice('messages.country', 1)) }}</x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse ($resellers as $reseller)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $reseller['id'] }}">
                            <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                <a href="{{$reseller->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $reseller['id'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$reseller->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $reseller['company_name'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$reseller->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $reseller->provider['company_name'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                <a href="{{$reseller->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $reseller->mpnid ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$reseller->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $reseller->country->name ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="z-10">
                                    <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a wire:click="edit({{ $reseller->id }})" class="dropdown-item" href="#">
                                            <x-icon.edit></x-icon.edit>
                                            {{ ucwords(trans_choice('messages.edit', 1)) }}
                                        </a>
                                        @canImpersonate
                                        @if(!empty($reseller->format()['mainUser']))
                                        <a class="dropdown-item" href="{{ route('impersonate', $reseller->format()['mainUser']['id'])}}">
                                            <x-icon.impersonate></x-icon.impersonate>
                                            {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                        </a>
                                        @endif
                                        @endCanImpersonate
                                    </div>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="9">
                                <div class="flex items-center justify-center space-x-2">
                                    <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                    <span class="py-8 text-xl font-medium text-cool-gray-400">No Resellers found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-slot>
                </x-tableazure>
                <div>
                    {{ $resellers->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Save Transaction Modal -->
    <div>
        @if($showEditModal == true)
        <form @if($showCreateUser === false) { wire:submit.prevent="save({{$reseller->id}})" } @else { wire:submit.prevent="savecreate" } @endif>
            <x-modal.slideout wire:model.defer="showEditModal">
                @if ($showCreateUser == false)
                <x-slot name="title">{{ ucwords(trans_choice('messages.edit_reseller', 1)) }}</x-slot>
                @elseif($showCreateUser == true)
                <x-slot name="title">{{ ucwords(trans_choice('messages.create_reseller', 1)) }}</x-slot>
                @endif
                <x-slot name="content">
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                                        <x-input  wire:model.debounce.500ms="editing.company_name" type="text" id="company_name" name="company_name" class="@error('editing.company_name') is-invalid @enderror"></x-input>
                                        @error('editing.company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                                        <x-input wire:model.debounce.500ms="editing.nif" type="text" id="nif" name="nif" class="@error('editing.nif') is-invalid @enderror"></x-input>
                                        @error('editing.nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <select wire:model.debounce.500ms="editing.country_id" name="country_id" class="form-control @error('editing.country_id') is-invalid @enderror" sf-validate="required" required>
                                                <option value="{{ old('country_id')}}" selected></option>
                                                @foreach ($countries as $key => $country)
                                                <option value="{{$key}}">{{$country}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</x-label>
                                    <x-input wire:model.debounce.500ms="editing.address_1" type="text" id="address_1" name="address_1" class="@error('editing.address_1') is-invalid @enderror" placeholder="1234 Main St"></x-input>
                                    @error('editing.address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-3">
                                    <x-label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</x-label>
                                    <x-input wire:model.debounce.500ms="editing.address_2" type="text" id="address_2" name="address_2" class="@error('editing.address_2') is-invalid @enderror" placeholder="Appartment or numer"></x-input>
                                    @error('editing.address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                        <x-input wire:model.debounce.500ms="editing.city" type="text" id="city" name="city" class=" mb-4 @error('editing.city') is-invalid @enderror"></x-input>
                                        @error('editing.city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                        <x-input wire:model.debounce.500ms="editing.state" name="state" type="text" class="@error('editing.state') is-invalid @enderror" id="state" placeholder=""></x-input>
                                        @error('editing.state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="zip">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                                        <x-input wire:model.debounce.500ms="editing.postal_code" name="postal_code" type="text" class="@error('editing.postal_code') is-invalid @enderror" id="postal_code" placeholder="" required></x-input>
                                        @error('editing.postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 col-lg-4 col-md-6">
                                        <x-label for="mpnid" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</x-label>
                                        <x-input wire:model.debounce.500ms="editing.mpnid" type="number" class="@error('editing.mpnid') is-invalid @enderror"></x-input>
                                        @error('editing.mpnid')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    @if ($showCreateUser == false)
                                    <div class="mb-4 col-lg-4 col-md-6">
                                        <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <select wire:model.debounce.500ms="editing.price_list_id" name="price_list_id" class="form-control @error('editing.price_list_id') is-invalid @enderror" sf-validate="required">
                                                @foreach ($reseller->provider->availablePriceLists as $pricelist)
                                                <option value="{{$pricelist->id}}" {{ $reseller->pricelist->id === $pricelist->id ? 'selected' : '' }}>{{$pricelist->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    @endif
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @if ($showCreateUser == true)
                        <h3>User Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-label for="status">@lang('Status')</x-label>
                                    <select wire:model.debounce.500ms="creatingUser.status_id" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                        <option value="{{ old('status')}}" selected></option>
                                        @foreach ($statuses as $key => $status)
                                        <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                        @endforeach
                                    </select>
                                    @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="name">@lang('First Name')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.name" type="text" class="@error('creatingUser.name') is-invalid @enderror" id="name" name="name" placeholder="First Name" value="{{ old('name') }}"></x-input>
                                    @error('creatingUser.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="last_name">@lang('Last Name')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.last_name" type="text" class="@error('creatingUser.last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name')  }}"></x-input>
                                    @error('creatingUser.last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-label for="socialite_id">@lang('creatingUser.socialite_id')</x-label>
                                    <div class="form-group">
                                        <x-input wire:model.debounce.500ms="creatingUser.socialite_id" class="@error('socialite_id') is-invalid @enderror" type="text" name="socialite_id" id='socialite_id' value="{{ old('socialite_id') }}"></x-input>
                                        @error('creatingUser.socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-label for="phone">@lang('Phone')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.phone" type="text" class="@error('creatingUser.phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="Phone" value="{{ old('phone') }}"></x-input>
                                    @error('creatingUser.phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="address">@lang('Address')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.address" type="text" class="@error('creatingUser.address') is-invalid @enderror" id="address"
                                    name="address" placeholder="Address" value="{{ old('address') }}"></x-input>
                                    @error('creatingUser.address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-label for="email">@lang('Email')</x-label>
                                    <x-input wire:model.debounce.500ms="email" type="email" class="@error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}"></x-input>
                                    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                </div>
                                <div class="form-group">
                                    <x-label for="password">{{ __('Password') }}</x-label>
                                    <x-input wire:model.debounce.500ms="password" type="password" class="@error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}"></x-input>
                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
                                    <x-input wire:model.debounce.500ms="password_confirmation" type="password" class="@error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"></x-input>
                                    @error('password_confirmation')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                        @endif
                    </section>
                </x-slot>
                <x-slot name="footer">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('cancel', 1))}}
                    </button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('save', 1))}}
                    </button>
                </x-slot>
            </x-modal.slideout>
        </form>
        @endif
    </div>
</div>

