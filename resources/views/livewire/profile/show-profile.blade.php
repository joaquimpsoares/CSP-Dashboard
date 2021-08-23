<div>
    <main class="flex flex-1 overflow-hidden bg-white">
        <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
            <div class="flex flex-1 xl:overflow-hidden">
                <!-- Sidebar -->
                @livewire('user.sidebar', ['user' => $user], key($user->id))
                <div class="flex-grow">
                    <div class="p-6 space-y-6">
                        <div class="pt-6 divide-y divide-gray-200">
                            <div class="px-4 sm:px-6">
                                @if(Auth::user()->userlevel->name == 'Provider')
                                <form wire:submit.prevent="savePhoto">
                                    <section>
                                        <h2 class="text-lg font-medium leading-6 text-gray-900">Company Logo</h2>
                                        <div class="text-sm"></div>
                                        <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                            <div class="sm:w-1/3">
                                                <div class="px-4 py-6 bg-white sm:p-6">
                                                    <div>
                                                        <p class="mt-1 text-sm text-gray-500">Set your company Logo.</p>
                                                    </div>
                                                    <div class="sm:col-span-6">
                                                        <label for="photo" class="block text-sm font-medium text-blue-gray-900">
                                                            Logo
                                                        </label>
                                                        <div class="flex items-center mt-1">
                                                            @if ($photo)
                                                            <img class="inline-block w-auto h-14 " src="{{$photo->temporaryUrl()}}" alt="">
                                                            @else
                                                            <img class="inline-block w-auto h-14 " src="{{$logo ?? $logo->temporaryUrl()}}" alt="">
                                                            @endif
                                                            <div class="flex ml-4">
                                                                <div class="relative flex items-center px-3 py-1 mr-3 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                                                    <label for="user_photo" class="relative text-sm font-medium pointer-events-none text-blue-gray-900">
                                                                        <span>Change</span>
                                                                        <span class="sr-only"> Company Logo</span>
                                                                    </label>
                                                                    <input wire:model="photo" id="photo" name="photo" type="file" class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                                                </div>
                                                                @if(isset($logo))
                                                                <x-a color="red" type="submit" wire:click.prevent='removePhoto'>
                                                                    Remove
                                                                </x-a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div wire:loading wire:target="photo">Uploading...</div>
                                                    <div class="text-red-700">
                                                        @error('photo') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col py-5 mt-3 mb-3 border-t border-gray-200">
                                            <div class="flex self-end">
                                                <x-button  type="submit">Save Changes</x-button>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                                @endif
                            </div>
                        </div>


                        <section>
                            <form action="#" method="POST" wire:submit.prevent="save">
                                <div class="px-4 py-6 bg-white sm:p-6">
                                    <div>
                                        <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Company details</h2>
                                        <p class="mt-1 text-sm text-gray-500">Update your Company billing information.</p>
                                    </div>
                                    <div class="grid grid-cols-4 gap-6 mt-6">
                                        <div class="col-span-4 sm:col-span-2">
                                            <x-label for="nif">{{ucwords(trans_choice('messages.company_name', 1))}}</x-label>
                                            <x-input wire:model="company_name" type="text" name="company_name"   class="@error('company_name') is-invalid @enderror" id='company_name' ></x-input>
                                            @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <x-label for="nif">{{ucwords(trans_choice('messages.nif', 1))}}</x-label>
                                            <x-input wire:model="nif" type="text" name="nif"   class="@error('nif') is-invalid @enderror" id='nif' ></x-input>
                                            @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <x-label for="address">{{ucwords(trans_choice('messages.address', 1))}}</x-label>
                                            <x-input wire:model="address" type="text" name="address"   class="@error('address') is-invalid @enderror" id='address' ></x-input>
                                            @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <x-label for="city">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                            <x-input wire:model="city" type="text" name="city"   class="@error('city') is-invalid @enderror" id='city' ></x-input>
                                            @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                            <x-input wire:model="state" type="text" name="state"   class="@error('state') is-invalid @enderror" id='state' ></x-input>
                                            @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                            <div class="mb-3 input-group">
                                                <select wire:model="country_id" name="country_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('country_id') is-invalid @enderror" sf-validate="required">
                                                    <option value="">Choose...</option>
                                                    @foreach ($countries as $key => $country)
                                                    <option value="{{$key}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <x-label for="postal_code">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                                            <x-input wire:model="postal_code" type="text" name="postal_code"   class="@error('postal_code') is-invalid @enderror" id='postal_code' ></x-input>
                                            @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="flex flex-col py-5 mt-3 mb-3 border-t border-gray-200">
                                        <div class="flex self-end">
                                            <x-button  type="submit">Save Changes</x-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>
