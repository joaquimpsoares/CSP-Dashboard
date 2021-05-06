<div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="bg-white p-8">
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="flex justify-between items-center">
                <div>
                    <h4>{{ ucwords(trans_choice('messages.reseller_table', 2)) }}</h4>
                </div>

                <div class="flex justify-between">
                    <div>
                        <button type="button" class="px-2 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                            </svg>
                            Export
                        </button>
                    </div>
                    <div>
                        <button type="button" class="ml-2 bg-indigo-600 py-1 px-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 mt-2">
                <div class="py-1 align-middle inline-block min-w-full px-4">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.country', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.mpn', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucwords(trans_choice('messages.created_at', 1)) }}</th>
                                    <th scope="col" class="relative px-2 py-2"><span class="sr-only">{{ ucwords(trans_choice('messages.action', 1)) }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resellers as $reseller)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-900"><a href="{{ $reseller['path'] }}">{{ $reseller['id'] }}</a></td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500"><a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a></td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">{{ $reseller['customers'] }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500"><a href="{{$reseller['provider']->format()['path']}}">{{ $reseller['provider']['company_name'] }}</a></td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">{{ $reseller['country'] }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">{{ $reseller['mpnid'] }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500">{{ $reseller['created_at'] }}</td>
                                    <td class="px-2 py-2 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="z-10">
                                            <button type="button" class="px-1 py-1 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ $reseller['path'] }}/edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                    Edit    
                                                </a>
                                                <a class="dropdown-item" href="{{ route('impersonate', $reseller['mainUser']->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Impersonate
                                                </a>
                                                {{-- <div class="dropdown-divider"></div> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Empty</td>
                                </tr>
                                @endforelse
                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-cloak :class="resellerOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'" class="fixed top-0 right-0 z-40 w-screen h-full max-w-2xl px-6 py-4 transition duration-300 transform bg-white border-l-2 border-gray-300">
        <div class="absolute inset-0 overflow-hidden">
            <div x-description="Background overlay, show/hide based on slide-over state." class="absolute inset-0" @click="resellerOpen = !resellerOpen" aria-hidden="true"></div>
            <div class="fixed inset-y-0 right-0 flex pl-10 sm:pl-16">
                <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-2xl" x-description="Slide-over panel, show/hide based on slide-over state.">
                    <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                    Panel title
                                </h2>
                                <div class="flex items-center ml-3 h-7">
                                    <button class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="resellerOpen = !resellerOpen">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative flex-1 px-4 mt-6 sm:px-6">
                            {{-- @livewire('reseller.edit-reseller', ['reseller' => $reseller]) --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>