@props([
    'hidden' => null,
    'sm:table-cell' => null,
])

<tr {{ $attributes->merge(['class' => 'hover:bg-gray-100']) }}>
    {{ $slot }}
</tr>
