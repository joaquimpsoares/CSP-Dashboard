<div>
    <style>
        .toogle-a input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-a input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-b input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-b input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-c input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-c input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-d input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-d input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

    </style>
    <main class="flex flex-1 overflow-hidden bg-white">
        <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="bg-white border-b border-blue-gray-200 xl:hidden">
                <div class="flex items-start max-w-3xl px-4 py-3 mx-auto sm:px-6 lg:px-8">
                    <a href="#" class="inline-flex items-center -ml-1 space-x-3 text-sm font-medium text-blue-gray-900">
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg class="w-5 h-5 text-blue-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span>Settings</span>
                    </a>
                </div>
            </nav>

            <div class="flex flex-1 xl:overflow-hidden">
                <!-- Sidebar -->
                @livewire('user.sidebar', ['user' => $user], key($user->id))
                <!-- Panel -->
                <div class="flex-grow">
                    <!-- Panel body -->
                    <div class="p-6 space-y-6">
                        <section>
                            <div class="pt-6 divide-y divide-gray-200">
                                <div class="px-4 sm:px-6">
                                    <div>
                                        <h2 class="text-lg font-medium leading-6 text-gray-900">{{ucwords(trans_choice('messages.notifications', 1))}}</h2>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ucwords(trans_choice('descriptions.notifications_description', 1))}}
                                        </p>
                                    </div>
                                    <ul class="mt-2 ">
                                        <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                            <div class="flex flex-col">
                                                <p class="text-sm font-medium text-gray-900" id="privacy-option-1-label">
                                                    {{ucwords(trans_choice('messages.email', 1))}}
                                                </p>
                                                <p class="text-sm text-gray-500" id="privacy-option-1-description">
                                                    {{ucwords(trans_choice('descriptions.recieve_email_notifications', 1))}}

                                                </p>
                                            </div>
                                            <label for="toogle-a" class="relative inline-flex items-center cursor-pointer toogle-a">
                                                <input wire:model='mail' id="toogle-a" type="checkbox" class="hidden">
                                                <div class="w-10 h-4 transition duration-300 bg-gray-300 border border-gray-100 rounded-full shadow-inner bar"></div>
                                                <div class="absolute w-6 h-6 transition duration-300 bg-gray-400 rounded-full shadow-md dot -left-1"></div>
                                            </label>
                                        </li>
                                        @if($mail == true)
                                        <div class="col-span-12">
                                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                            <input wire:model='teams_webhook' type="text" name="url" id="url" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                        </div>
                                        @endif
                                        <li class="flex items-center justify-between py-4" x-data="{ on: false }">
                                            <div class="flex flex-col">
                                                <p class="text-sm font-medium text-gray-900" id="privacy-option-2-label">
                                                    {{ucwords(trans_choice('messages.teams', 1))}}
                                                </p>
                                                <p class="text-sm text-gray-500" id="privacy-option-2-description">
                                                    {{ucwords(trans_choice('descriptions.recieve_teams_notifications', 1))}}
                                                </p>
                                            </div>
                                            <div class="flex flex-col">
                                                <label for="toogle-b" class="relative inline-flex items-center cursor-pointer toogle-b">
                                                    <input wire:model='teams' id="toogle-b" type="checkbox" class="hidden">
                                                    <div class="w-10 h-4 transition duration-300 bg-gray-300 border border-gray-100 rounded-full shadow-inner bar"></div>
                                                    <div class="absolute w-6 h-6 transition duration-300 bg-gray-400 rounded-full shadow-md dot -left-1"></div>
                                                </label>
                                            </div>
                                        </li>
                                        @if($teams == true)
                                        <div class="col-span-12">
                                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                            <input wire:model='teams_webhook' type="text" name="url" id="url" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                        </div>
                                        @endif
                                    </ul>
                                </div>
                                <div class="flex justify-end px-4 py-4 mt-4 sm:px-6">
                                    <x-a class="inline-flex justify-center px-4 py-2 ml-5 text-sm font-medium " color="red" type="button" >
                                        Cancel
                                    </x-a>
                                    <x-a type="submit" wire:click='save' class="inline-flex justify-center px-4 py-2 ml-5 text-sm font-medium ">
                                        Save
                                    </x-a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
