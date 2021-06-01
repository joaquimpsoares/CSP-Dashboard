

<main class="pb-10 mx-auto max-w-8xl lg:py-0 lg:px-0">
    @include('partials.messages')
    <div class="mb-8 bg-white rounded-sm shadow-lg">
        <div class="flex flex-col md:flex-row md:-mr-px">
            <!-- Sidebar -->
            <div class="flex px-3 py-6 overflow-x-scroll border-b border-gray-200 flex-nowrap no-scrollbar md:block md:overflow-auto md:border-b-0 md:border-r md:w-60 md:space-y-3">
                <!-- Group 1 -->
                <div>
                    <div class="mb-3 text-xs font-semibold text-gray-400 uppercase">Business settings</div>
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
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">Billing & Invoices</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Group 2 -->
                <div>
                    <div class="mb-3 text-xs font-semibold text-gray-400 uppercase">Experience</div>
                    <ul class="flex mr-3 flex-nowrap md:block md:mr-0">
                        <li class="mr-0.5 md:mr-0 md:mb-0.5">
                            <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap" href="#0">
                                <svg class="flex-shrink-0 w-4 h-4 mr-2 text-gray-500 fill-current" viewBox="0 0 16 16">
                                    <path d="M7.001 3h2v4h-2V3zm1 7a1 1 0 110-2 1 1 0 010 2zM15 16a1 1 0 01-.6-.2L10.667 13H1a1 1 0 01-1-1V1a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1zM2 11h9a1 1 0 01.6.2L14 13V2H2v9z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600 hover:text-gray-700">Give Feedback</span>
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
                            <div class="mt-5 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                <div class="sm:w-1/3">
                                    <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.name', 1))}}</x-label>
                                    <x-input id="name" class="w-full form-input" type="text" value="{{$user->name}}" />
                                    </div>
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.last_name', 1))}}</x-label>
                                        <x-input id="business-id" class="w-full form-input" type="text" value="{{$user->last_name}}" ></x-input>
                                    </div>

                                </div>
                            </section>
                            <section>
                                <div class="mt-5 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.address', 1))}}</x-label>
                                        <x-input id="name" class="w-full form-input" type="text" value="{{$user->address}}" ></x-input>
                                    </div>
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="business-id">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                        <x-input id="business-id" class="w-full form-input" type="text" value="{{$user->city}}" ></x-input>
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
                                <div class="mt-5 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                                    <div class="sm:w-1/3">
                                        <x-label class="block mb-1 text-sm font-medium" for="name">{{ucwords(trans_choice('messages.phone', 1))}}</x-label>
                                        <x-input id="name" class="w-full form-input" type="text" value="{{$user->phone}}" ></x-input>
                                    </div>
                                </section>
                                <section>
                                    <h2 class="mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.locale', 1))}}</h2>
                                    <div class="text-sm">With this update, online-only files will no longer appear to take up hard drive space.</div>
                                    <div class="flex flex-wrap mt-2">
                                        <div class="mr-2">
                                            <select wire:model="locale" name="locale" class="form-control @error('locale') is-invalid @enderror" sf-validate="required">
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
                                    </section>
                                    <!-- Email -->
                                    <section>
                                        <h2 class="mb-1 text-xl font-bold text-gray-800">Email</h2>
                                        <div class="text-sm">Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia.</div>
                                        <div class="flex flex-wrap mt-5">
                                            <div class="mr-2">
                                                <x-label class="sr-only" for="email">Business email</x-label>
                                                <x-input id="email" class="form-input" type="email" value="{{$user->email}}" ></x-input>
                                            </div>
                                            <button wire:click="sendInvitation" class="text-indigo-500 border-gray-200 shadow-sm btn hover:border-gray-300">Change</button>
                                        </div>
                                    </section>
                                    <!-- Password -->
                                    <section>
                                        <h2 class="mb-1 text-xl font-bold text-gray-800">Password</h2>
                                        <div class="text-sm">You can set a permanent password if you don't want to use temporary login codes.</div>
                                        <div class="mt-5">
                                            <x-a class="text-indigo-500 border-gray-200 shadow-sm btn">Set New Password</x-a>
                                        </div>
                                    </section>
                                    <!-- Smart Sync -->
                                    <section>
                                        <h2 class="mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.status', 1))}}</h2>
                                        <div class="text-sm">With this update, online-only files will no longer appear to take up hard drive space.</div>
                                        <div class="flex flex-wrap mt-5">
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
                                    <section>
                                        <form id="gdpr-form" action="/gdpr/download" method="POST">
                                            <div class="flex flex-wrap mt-5">
                                                <section>
                                                    <h2 class="mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.gdpr', 1))}}</h2>
                                                    <div class="text-sm">Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia.</div>
                                                    <div class="flex flex-wrap mt-5">
                                                        <div class="mr-2">
                                                            <x-label class="sr-only" for="email">Business email</x-label>
                                                            <x-input name="password" type="password" class=" @error('password') is-invalid @enderror" id="password" value=""></x-input>
                                                        </div>
                                                        <button wire:click="sendInvitation" class="text-indigo-500 border-gray-200 shadow-sm btn hover:border-gray-300">Download</button>
                                                    </div>
                                                </section>
                                                @csrf
                                                <div class="col-md-6">
                                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                        </form>
                                    </section>
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
                        </div>
                    </form>
                </div>
            </main>
            {{-- <div class="row">
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
                                                            <x-label for="status">@lang('Status')</x-label>
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
                                                            <x-label for="locale">@lang('Locale')</x-label>
                                                            <input wire:model="locale" type="text" class=" @error('locale') is-invalid @enderror" id="locale"
                                                            name="address" placeholder="en,es" >
                                                            @error('locale')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <x-label for="name">@lang('First Name')</x-label>
                                                            <input wire:model="name" type="text" class=" @error('name') is-invalid @enderror" id="name" name="name" placeholder="@lang('First Name')"  >
                                                            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <x-label for="last_name">@lang('Last Name')</x-label>
                                                            <input wire:model="last_name" type="text" class=" @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="@lang('Last Name')">
                                                            @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <x-label for="phone">@lang('Phone')</x-label>
                                                            <input wire:model="phone" type="text" class=" @error('phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="@lang('Phone')" >
                                                            @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <x-label for="address">@lang('Address')</x-label>
                                                            <x-input wire:model="address" type="text" class=" @error('address') is-invalid @enderror" id="address" name="address" placeholder="@lang('Address')" />
                                                            @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <x-label for="address">@lang('Country')</x-label>
                                                            <select wire:model="country_id" name="country" class="form-control @error('country') is-invalid @enderror" sf-validate="required">
                                                                @if ($edit)
                                                                <option wire:model="country_id" value="{{ $edit && $user->country->id ? $user->country->id : ''}}" selected>{{ucwords(trans_choice($user->country->name, 1))}}</option>
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
                                                    <x-label for="email">@lang('Email')</x-label>
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
                                                    ></span>
                                                </span>
                                                <div class="form-group">
                                                    <x-label for="password">{{ $edit ? __("New Password") : __('Password') }}</x-label>
                                                    <input wire:model="password"  type="password" class=" @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" autocomplete="new-password"
                                                    @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
                                                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                                </div>
                                                <div class="form-group">
                                                    <x-label for="password_confirm">{{ $edit ? __("Confirm New Password") : __('Confirm Password') }}</x-label>
                                                    <input wire:model="password_confirmation" type="password" class=" @error('password_confirm') is-invalid @enderror" id="password_confirm" name="password_confirm"  value="{{ old('password_confirm') }}" autocomplete="new-password"
                                                    @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
                                                    @error('password_confirm')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <x-label for="socialite_id">@lang('socialite_id')</x-label>
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
                </div> --}}

                {{-- <div class="col-xl-3 col-lg-3">
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
                                            <x-label class="custom-file-x-label" for="customFileLang">Select file</x-label>
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
                                        <button type="submit" id="change-picture" class="mt-5 btn btn-outline-secondary btn-block">
                                            <i class="fa fa-camera"></i> @lang('Save Photo')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
