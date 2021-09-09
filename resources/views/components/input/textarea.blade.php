@props([
    'leadingAddOn' => false,
])

<div class="flex rounded-md shadow-sm">
    @if ($leadingAddOn)
        <span class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <textarea {{ $attributes->merge(['class' => 'flex-1 form-input border-cool-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5' . ($leadingAddOn ? ' rounded-none rounded-r-md' : '')]) }}/>
</div>


{{-- <textarea id="message" name="message" rows="4" class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea> --}}
