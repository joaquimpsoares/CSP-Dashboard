
@props(['color' => 'indigo'] )

<input
{{
 $attributes->merge(
    ['class' => "flex-1 block w-full focus:ring-{$color}-500 focus:border-{$color}-500 min-w-0 rounded-md sm:text-sm border-gray-300" ]) }}/>
