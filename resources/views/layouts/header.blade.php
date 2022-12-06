
<header class="bg-white border-b">
    <nav class="flex flex-col flex-shrink-0 px-4 py-0 bg-white lg:flex-row lg:items-center">
        <div class="flex items-center justify-between lg:mr-32">
            <button class="px-2 py-1 text-white border border-white rounded opacity-50 hover:opacity-75 lg:hidden" id="navbar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="flex-grow lg:flex" id="navbar-collapse">
            <div class="flex flex-col mt-3 mb-1 lg:flex-row lg:mx-auto lg:mt-0 lg:mb-0">
            </div>
            <div class="flex my-3 lg:my-0">
                <a href="https://tagydes.com/docs" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">
                    Docs
                </a>
                @livewire('search.global-search')
                <x-database-notifications/>
                <span class="hidden w-px h-6 mx-4 bg-gray-200 lg:flex" aria-hidden="true"></span>
                @livewire('store.cart-counter')
            </div>
        </div>
    </nav>
</header>
