@props(['color' => 'gray'] )
<button
{{
    $attributes->merge
    ([
    'class' => "bg-{$color}-800 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-{$color}-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
    ])
}}>
{{$slot}}
</button>
