<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div>
        <div class="flex justify-between">
            <div class="flex-1">
                <div class="mt-1 flex rounded-md shadow-sm">
                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/users -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model="search" type="text" name="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Microsoft 365 Essentials...">
                    </div>
                </div>
            </div>
            <div class="ml-2">
                <select wire:model="vendor" name="vendor" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value {{ $vendor === '' ? 'selected' : ''}}>Select a vendor</option>
                    @foreach($vendors as $option)
                    <option value="{{ $option }}" {{ $vendor === $option ? 'selected' : ''}}>{{ Str::ucfirst($option) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="ml-2">
                <select wire:model="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value {{ $category === '' ? 'selected' : ''}}> Select a category </option>
                    @foreach($categories as $option)
                    <option value="{{ $option }}" {{ $category === $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <ul class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-5 lg:gap-x-8 mt-6">
            @forelse($products as $product)
            <li>
                <div class="space-y-4">
                    <div class="aspect-w-3 aspect-h-2">
                        <img class="object-cover shadow-lg rounded-lg" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="">
                    </div>

                    <div class="space-y-2">
                        <div class="text-lg leading-6 font-medium space-y-1">
                            <h3 class="text-md">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm text-justify">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            No products found
            @endforelse
        </ul>
    </div>