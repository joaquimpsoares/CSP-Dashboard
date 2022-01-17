
@props(['color' => 'indigo'] )

<input
{{
 $attributes->merge(
    ['class' => "out-of-range:border-red-500 in-range:border-green-500 flex-1 block w-full focus:ring-{$color}-500 focus:border-{$color}-500 min-w-0 rounded-md sm:text-sm border-gray-300" ]) }}/>
