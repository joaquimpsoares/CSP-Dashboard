<div>
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
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">Privacy</h2>
                                    <p class="mt-1 text-sm text-gray-500">
                                      Ornare eu a volutpat eget vulputate. Fringilla commodo amet.
                                    </p>
                                  </div>
                                  <ul class="mt-2 divide-y divide-gray-200">
                                    <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                      <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-1-label">
                                          Available to hire
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-1-description">
                                          Nulla amet tempus sit accumsan. Aliquet turpis sed sit lacinia.
                                        </p>
                                      </div>
                                      <button type="button" class="relative inline-flex flex-shrink-0 h-6 ml-4 transition-colors duration-200 ease-in-out bg-indigo-500 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500" role="switch" aria-checked="true" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-500': on, 'bg-gray-200': !(on) }" aria-labelledby="privacy-option-1-label" aria-describedby="privacy-option-1-description" :aria-checked="on.toString()" @click="on = !on">
                                        <span class="sr-only">Use setting</span>
                                        <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-5 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                      </button>
                                    </li>
                                    <li class="flex items-center justify-between py-4" x-data="{ on: false }">
                                      <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-2-label">
                                          Make account private
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-2-description">
                                          Pharetra morbi dui mi mattis tellus sollicitudin cursus pharetra.
                                        </p>
                                      </div>
                                      <button type="button" class="relative inline-flex flex-shrink-0 h-6 ml-4 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500" role="switch" aria-checked="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-500': on, 'bg-gray-200': !(on) }" aria-labelledby="privacy-option-2-label" aria-describedby="privacy-option-2-description" :aria-checked="on.toString()" @click="on = !on">
                                        <span class="sr-only">Use setting</span>
                                        <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                      </button>
                                    </li>
                                    <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                      <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-3-label">
                                          Allow commenting
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-3-description">
                                          Integer amet, nunc hendrerit adipiscing nam. Elementum ame
                                        </p>
                                      </div>
                                      <button type="button" class="relative inline-flex flex-shrink-0 h-6 ml-4 transition-colors duration-200 ease-in-out bg-indigo-500 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500" role="switch" aria-checked="true" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-500': on, 'bg-gray-200': !(on) }" aria-labelledby="privacy-option-3-label" aria-describedby="privacy-option-3-description" :aria-checked="on.toString()" @click="on = !on">
                                        <span class="sr-only">Use setting</span>
                                        <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-5 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                      </button>
                                    </li>
                                    <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                      <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900" id="privacy-option-4-label">
                                          Allow mentions
                                        </p>
                                        <p class="text-sm text-gray-500" id="privacy-option-4-description">
                                          Adipiscing est venenatis enim molestie commodo eu gravid
                                        </p>
                                      </div>
                                      <button type="button" class="relative inline-flex flex-shrink-0 h-6 ml-4 transition-colors duration-200 ease-in-out bg-indigo-500 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500" role="switch" aria-checked="true" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-500': on, 'bg-gray-200': !(on) }" aria-labelledby="privacy-option-4-label" aria-describedby="privacy-option-4-description" :aria-checked="on.toString()" @click="on = !on">
                                        <span class="sr-only">Use setting</span>
                                        <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-5 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                      </button>
                                    </li>
                                  </ul>
                                </div>
                                <div class="flex justify-end px-4 py-4 mt-4 sm:px-6">
                                  <button type="button" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500">
                                    Cancel
                                  </button>
                                  <button type="submit" class="inline-flex justify-center px-4 py-2 ml-5 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-light-blue-700 hover:bg-light-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500">
                                    Save
                                  </button>
                                </div>
                              </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
