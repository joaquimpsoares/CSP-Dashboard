
@props(['color' => 'indigo'] )

<select
{{
    $attributes->merge
    ([
    'class' => "mtblock w-full text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
    ])
}}>

