@props([
    'visibility' => null,
    'tablecell' => null,
])

<td {{ $attributes->merge(['class' => 'px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 '. $visibility . ' ' . $tablecell]) }}>
    {{ $slot }}
</td>
