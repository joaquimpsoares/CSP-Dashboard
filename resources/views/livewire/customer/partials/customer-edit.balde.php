<div>
                    <!-- Save Transaction Modal -->
                    <form wire:submit.prevent="save({{$customer->id}})">
                        <x-modal.slideout wire:model.defer="showEditModal">
                            <x-slot name="title">Edit Customer</x-slot>
                            <x-slot name="content">
                                <section class="dark-grey-text">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                                                    <x-input  wire:model="editing.company_name" type="text" id="company_name" name="company_name" class="@error('editing.company_name') is-invalid @enderror"></x-input>
                                                    @error('editing.company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                                                    <x-input wire:model="editing.nif" type="text" id="nif" name="nif" class="@error('editing.nif') is-invalid @enderror"></x-input>
                                                    @error('editing.nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col-md-12">
                                                    <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                                    <div class="mb-3 input-group">
                                                        <select wire:model="editing.country_id" name="country_id" class="form-control @error('editing.country_id') is-invalid @enderror" sf-validate="required">
                                                            <option value="{{$customer->country->name}}">{{$customer->country->name}}</option>
                                                            @foreach ($countries as $key => $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('editing.country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <x-label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</x-label>
                                                <x-input wire:model="editing.address_1" type="text" id="address_1" name="address_1" class="@error('editing.address_1') is-invalid @enderror" placeholder="1234 Main St"></x-input>
                                                @error('editing.address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <x-label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</x-label>
                                                <x-input wire:model="editing.address_2" type="text" id="address_2" name="address_2" class="@error('editing.address_2') is-invalid @enderror" placeholder="Appartment or numer"></x-input>
                                                @error('editing.address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <x-label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                                    <x-input wire:model="editing.city" type="text" id="city" name="city" class=" mb-4 @error('editing.city') is-invalid @enderror"></x-input>
                                                    @error('editing.city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                                    <x-input wire:model="editing.state" name="state" type="text" class="@error('editing.state') is-invalid @enderror" id="state" placeholder=""></x-input>
                                                    @error('editing.state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <x-label for="zip">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                                                    <x-input wire:model="editing.postal_code" name="postal_code" type="text" class="@error('editing.postal_code') is-invalid @enderror" id="postal_code" placeholder="" required></x-input>
                                                    @error('editing.postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-4 col-lg-4 col-md-6">
                                                    <div class="mb-3 input-group">
                                                        <div>
                                                            <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                                            <div class="mb-3 input-group">
                                                                <select wire:model.debounce.500ms="editing.price_list_id" name="price_list_id" class="form-control @error('editing.price_list_id') is-invalid @enderror" sf-validate="required">
                                                                    @foreach ($customer->resellers->first()->availablePriceLists as $pricelist)
                                                                    <option value="{{$pricelist->id}}" >{{$pricelist->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('editing.price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                            </div>
                                                            <label for="editing.markup" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.markup', 1)) }}</label>
                                                            <div class="relative mt-1 rounded-md shadow-sm">
                                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                    <span class="text-gray-500 sm:text-sm">
                                                                        %
                                                                    </span>
                                                                </div>
                                                                <input value="{{$customer->markup}}" wire:model="editing.markup" type="text" name="editing.marku" id="editing.markup" class="block w-full pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-sm" placeholder="00" aria-describedby="price-markup">
                                                            </div>
                                                            @error('editing.markup')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                                                        <div class="form-group">
                                                            <select wire:model="editing.status_id" name="status" class="form-control @error('editing.status') is-invalid @enderror" sf-validate="required">
                                                                <option value="{{$customer->status->id}}" selected>{{ucwords(trans_choice($customer->status->name, 1))}}</option>
                                                                @foreach ($statuses  as $key => $status)
                                                                <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('editing.status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    </div>
                </div>
