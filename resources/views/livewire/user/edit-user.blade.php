

<main class="pb-10 mx-auto max-w-8xl lg:py-0 lg:px-0">
    @include('partials.messages')
    <div class="mb-8 bg-white rounded-sm shadow-lg">
        <div class="flex flex-col md:flex-row md:-mr-px">
            <!-- Sidebar -->
            <div class="flex px-3 py-6 overflow-x-scroll border-b border-gray-200 flex-nowrap no-scrollbar md:block md:overflow-auto md:border-b-0 md:border-r md:w-60 md:space-y-3">
                <!-- Group 1 -->
                <div>
                    <div class="mb-3 text-xs font-semibold text-gray-400 uppercase">
                        Business settings
                    </div>
                    <ul class="flex mr-3 flex-nowrap md:block md:mr-0">
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap bg-indigo-50" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-indigo-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M12.311 9.527c-1.161-.393-1.85-.825-2.143-1.175A3.991 3.991 0 0012 5V4c0-2.206-1.794-4-4-4S4 1.794 4 4v1c0 1.406.732 2.639 1.832 3.352-.292.35-.981.782-2.142 1.175A3.942 3.942 0 001 13.26V16h14v-2.74c0-1.69-1.081-3.19-2.689-3.733zM6 4c0-1.103.897-2 2-2s2 .897 2 2v1c0 1.103-.897 2-2 2s-2-.897-2-2V4zm7 10H3v-.74c0-.831.534-1.569 1.33-1.838 1.845-.624 3-1.436 3.452-2.422h.436c.452.986 1.607 1.798 3.453 2.422A1.943 1.943 0 0113 13.26V14z" />
                                </svg>
                                <span class="text-sm font-medium text-indigo-500">My account</span>
                            </a>
                        </li>
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M14.3.3c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-8 8c-.2.2-.4.3-.7.3-.3 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l8-8zM15 7c.6 0 1 .4 1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8c.6 0 1 .4 1 1s-.4 1-1 1C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6c0-.6.4-1 1-1z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">My notifications</span>
                            </a>
                        </li>
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M3.414 2L9 7.586V16H7V8.414l-5-5V6H0V1a1 1 0 011-1h5v2H3.414zM15 0a1 1 0 011 1v5h-2V3.414l-3.172 3.172-1.414-1.414L12.586 2H10V0h5z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">Connected Apps</span>
                            </a>
                        </li>
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M5 9h11v2H5V9zM0 9h3v2H0V9zm5 4h6v2H5v-2zm-5 0h3v2H0v-2zm5-8h7v2H5V5zM0 5h3v2H0V5zm5-4h11v2H5V1zM0 1h3v2H0V1z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">Plans</span>
                            </a>
                        </li>
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M15 4c.6 0 1 .4 1 1v10c0 .6-.4 1-1 1H3c-1.7 0-3-1.3-3-3V3c0-1.7 1.3-3 3-3h7c.6 0 1 .4 1 1v3h4zM2 3v1h7V2H3c-.6 0-1 .4-1 1zm12 11V6H2v7c0 .6.4 1 1 1h11zm-3-5h2v2h-2V9z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">
                                    Billing & Invoices
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Group 2 -->
                <div>
                    <div class="mb-3 text-xs font-semibold text-gray-400 uppercase">
                        Experience
                    </div>
                    <ul class="flex mr-3 flex-nowrap md:block md:mr-0">
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M7.001 3h2v4h-2V3zm1 7a1 1 0 110-2 1 1 0 010 2zM15 16a1 1 0 01-.6-.2L10.667 13H1a1 1 0 01-1-1V1a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1zM2 11h9a1 1 0 01.6.2L14 13V2H2v9z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">
                                    Give Feedback
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Panel -->
            <div class="flex-grow">
                <!-- Panel body -->
                <div class="p-6 space-y-6">
                    <!-- Picture -->
                    <section>
                        <form wire:submit.prevent="savephoto">
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
                        </form>
                    </section>
                    <!-- Business Profile -->
                    <form wire:submit.prevent="savedetails">
                        <section>
                            <h2 class="mb-1 text-xl font-bold text-gray-800">Business Profile</h2>
                            <div class="text-sm">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</div>
                            <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                <div class="sm:w-1/3">
                                    <x-label class="block mb-1 text-sm font-medium" for="name">
                                        {{ucwords(trans_choice('messages.name', 1))}}
                                    </x-label>
                                    <x-input wire:model='name' id="name" class="w-full form-input" type="text"/>
                                </div>
                                <div class="sm:w-1/3">
                                    <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.last_name', 1))}}</x-label>
                                    <x-input wire:model='last_name' id="business-id" class="w-full form-input" type="text"></x-input>
                                </div>
                            </div>
                        </section>
                            <section>
                                <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.address', 1))}}</x-label>
                                        <x-input wire:model='address' id="name" class="w-full form-input" type="text"></x-input>
                                    </div>
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                        <x-input wire:model='city' id="business-id" class="w-full form-input" type="text"></x-input>
                                    </div>
                                    <div class="sm:w-1/3">
                                        <x-label for="address">@lang('Country')</x-label>
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
                            </section>
                            <section>
                                <div class="mt-3 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.phone', 1))}}</x-label>
                                        <x-input wire:model='phone' id="name" class="w-full form-input" type="text"></x-input>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="mt-3 mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.locale', 1))}}</h2>
                                    <div class="text-sm">
                                        Choose the language of the platform.
                                    </div>
                                    <div class="flex flex-wrap mt-2">
                                        <div class="mr-2">
                                            <select wire:model="locale" name="locale" @error('locale') is-invalid @enderror" sf-validate="required">
                                                @if ($edit)
                                                <option wire:model="locale" value="{{ $edit && $user->status->id ? $user->status->id : ''}}" selected>{{$user->locale}}</option>
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
                                    <div class="text-sm">You can send an invitation email to the user.</div>
                                    <div class="flex flex-wrap mt-3">
                                        <div class="mr-2">
                                            <x-label class="sr-only" for="email">Business email</x-label>
                                            <x-input wire:model="email" id="email" class="form-input" type="email"></x-input>
                                        </div>
                                        <button wire:click="sendInvitation" class="text-indigo-500 border-gray-200 shadow-sm btn hover:border-gray-300">{{ucwords(trans_choice('messages.sendinvitation', 1))}}</button>
                                    </div>
                                </section>
                                <!-- Password -->
                                <section>
                                    <h2 class="mt-3 mb-1 text-xl font-bold text-gray-800">Password</h2>
                                    <div class="text-sm">You can set a permanent password if you don't want to use temporary login codes.</div>
                                    <div class="mt-3">
                                        <x-a class="text-indigo-500 border-gray-200 shadow-sm btn">Set New Password</x-a>
                                    </div>
                                </section>
                                <!-- Smart Sync -->
                                <section>
                                    <h2 class="mt-3 mb-3 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.status', 1))}}</h2>
                                    <div class="text-sm">With this update, online-only files will no longer appear to take up hard drive space.</div>
                                    <div class="flex flex-wrap mt-3">
                                        <x-label for="status">{{ucwords(trans_choice('messages.status', 1))}}</x-label>
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
                                </section>
                                @livewire('user.gdpr')
                            </div>
                            <!-- Panel footer -->
                            <footer>
                                <div class="flex flex-col px-6 py-5 border-t border-gray-200">
                                    <div class="flex self-end">
                                        <x-a class="mr-3" color="red">Cancel</x-a>
                                        <button wire:click.prevent="savedetails" type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </form>
                </div>
            </div>
        </main>
