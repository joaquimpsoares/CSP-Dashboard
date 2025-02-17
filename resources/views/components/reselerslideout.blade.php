<div><!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
      <div class="absolute inset-0 overflow-hidden">
        <!-- Background overlay, show/hide based on slide-over state. -->
        <div class="absolute inset-0" aria-hidden="true"></div>

        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
          <!--
            Slide-over panel, show/hide based on slide-over state.

            Entering: "transform transition ease-in-out duration-500 sm:duration-700"
              From: "translate-x-full"
              To: "translate-x-0"
            Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
              From: "translate-x-0"
              To: "translate-x-full"
          -->
          <div class="w-screen max-w-2xl">
            <div class="flex flex-col h-full py-6 overflow-y-scroll bg-white shadow-xl">
              <div class="px-4 sm:px-6">
                <div class="flex items-start justify-between">
                  <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                    Panel title
                  </h2>
                  <div class="flex items-center ml-3 h-7">
                    <button class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <span class="sr-only">Close panel</span>
                      <!-- Heroicon name: outline/x -->
                      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="relative flex-1 px-4 mt-6 sm:px-6">
                <!-- Replace with your content -->
                <div class="absolute inset-0 px-4 sm:px-6">
                  <div class="h-full border-2 border-gray-200 border-dashed" aria-hidden="true"></div>
                </div>
                <!-- /End replace -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
</div>
