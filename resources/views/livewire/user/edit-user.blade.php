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
                                <form wire:submit.prevent="savedetails">
                                    <!-- Picture -->
                                    {{-- <section>
                                        <h2 class="mb-5 text-xl font-bold text-gray-800">Picture</h2>
                                        <div class="flex items-center">
                                            <div class="flex items-center mt-1">
                                                @if ($photo)
                                                <img class="w-20 h-20 rounded-full" src="{{ $photo->temporaryUrl() }}" width="80" height="80" alt="User upload" />
                                                @else
                                                <img class="w-20 h-20 rounded-full" src="{{$user->avatar}}" width="80" height="80" alt="User upload" />
                                                @endif                                      <div class="flex ml-4">
                                                    <div class="relative flex items-center px-3 py-2 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                                        <label for="user_photo" class="relative mt-2 text-sm font-medium pointer-events-none text-blue-gray-900">
                                                            <span>Change</span>
                                                            <span class="sr-only"> user photo</span>
                                                        </label>
                                                        <input wire:model="photo" id="user_photo" name="user_photo" type="file" class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                                    </div>
                                                    <button type="button" class="px-3 py-2 ml-3 text-sm font-medium bg-transparent border border-transparent rounded-md text-blue-gray-900 hover:text-blue-gray-700 focus:outline-none focus:border-blue-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-gray-50 focus:ring-blue-500">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </section> --}}
                                    <!-- Business Profile -->
                                    <section>
                                        <h2 class="mb-1 text-xl font-bold text-gray-800">Business Profile</h2>
                                        <div class="text-sm"></div>
                                        <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                            <div class="sm:w-1/3">
                                                <x-label class="block mb-1 text-sm font-medium" for="name">
                                                    {{ucwords(trans_choice('messages.name', 1))}}
                                                </x-label>
                                                <x-input wire:model='editingUser.name' id="name" class="w-full form-input" type="text"/>
                                            </div>
                                            <div class="sm:w-1/3">
                                                <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.last_name', 1))}}</x-label>
                                                <x-input wire:model='editingUser.last_name' id="business-id" class="w-full form-input" type="text"></x-input>
                                            </div>
                                        </div>
                                    </section>
                                    <section>
                                        <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                            <div class="sm:w-1/3">
                                                <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.address', 1))}}</x-label>
                                                <x-input wire:model='editingUser.address' id="name" class="w-full form-input" type="text"></x-input>
                                            </div>
                                            <div class="sm:w-1/3">
                                                <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                                <x-input wire:model='editingUser.city' id="business-id" class="w-full form-input" type="text"></x-input>
                                            </div>
                                            <div class="sm:w-1/3">
                                                <x-label for="address">@lang('Country')</x-label>
                                                <select wire:model="editingUser.country_id" name="country" class="form-control @error('country') is-invalid @enderror" sf-validate="required">
                                                    @if ($edit)
                                                    {{-- <option wire:model="country_id" value="{{ $edit && $user->country->id ? $user->country->id : ''}}" selected>{{ucwords(trans_choice($user->country->name, 1))}}</option> --}}
                                                    @endif
                                                    @foreach ($countries as $key => $country)
                                                    <option value="{{$key}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </section>
                                    <section>
                                        <div class="mt-3 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                            <div class="sm:w-1/3">
                                                <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.phone', 1))}}</x-label>
                                                <x-input wire:model='editingUser.phone' id="name" class="w-full form-input" type="text"></x-input>
                                            </div>
                                        </section>
                                        <section>
                                            <h2 class="mt-3 mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.locale', 1))}}</h2>
                                            <div class="text-sm">
                                                Choose the language of the platform.
                                            </div>
                                            <div class="flex flex-wrap mt-2">
                                                <div class="mr-2">
                                                    <select wire:model="editingUser.locale" name="locale" @error('locale') is-invalid @enderror" sf-validate="required">
                                                        @if ($edit)
                                                        <option wire:model="editingUser.locale" selected>{{$user->locale}}</option>
                                                        @endif
                                                        <option value="es">Español</option>
                                                        <option value="fr">Français</option>
                                                        <option value="en">English</option>
                                                        <option value="el">Greek</option>
                                                    </select>
                                                    @error('locale')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Email -->
                                        <section>
                                            <h2 class="mt-3 mb-1 text-xl font-bold text-gray-800">Email</h2>
                                            <div class="text-sm">Invite user to the platform.</div>
                                            <div class="flex flex-wrap mt-3">
                                                <div class="mr-2">
                                                    <x-label class="sr-only" for="email">Business email</x-label>
                                                    <x-input wire:model="editingUser.email" id="email" class="form-input" type="email"></x-input>
                                                </div>
                                                <button wire:click="sendInvitation" class="text-indigo-500 border-gray-200 shadow-sm btn hover:border-gray-300">{{ucwords(trans_choice('messages.sendinvitation', 1))}}</button>
                                            </div>
                                        </section>
                                        <section>
                                            <h2 class="mt-3 mb-3 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.status', 1))}}</h2>
                                            <div class="text-sm"></div>
                                            <div class="flex flex-wrap mt-3">
                                                <x-label for="status">{{ucwords(trans_choice('messages.status', 1))}}</x-label>
                                                <select disabled wire:model="editingUser.status_id" name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                                                    @if ($edit)
                                                    <option value="{{ $edit && $user->status->id ? $user->status->id : ''}}" selected>{{ucwords(trans_choice($user->status->name, 1))}}</option>
                                                    @endif
                                                    @foreach ($statuses as $key => $status)
                                                    <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </section>
                                        <section>
                                            <div class="flex flex-wrap mt-3">
                                                @livewire('user.gdpr')
                                            </div>
                                        </section>
                                    </div>
                                    <!-- Panel footer -->
                                    <div class="flex flex-col py-5 mt-3 mb-3 border-t border-gray-200">
                                        <div class="flex self-end">
                                            <x-a class="mr-3" color="red">Cancel</x-a>
                                            <x-button wire:click.prevent="savedetails" type="submit">Save Changes</x-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
