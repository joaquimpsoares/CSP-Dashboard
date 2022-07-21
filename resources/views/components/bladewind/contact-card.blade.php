@props([
    'css' => '',
    'has_shadow' => 'true',
    'image' => asset('bladewind/images/avatar.png'),
    'name' => '',
    'mobile' => '',
    'email' => '',
    'department' => '',
    'position' => '',
    'birthday' => '',
])

<div class="bw-contact-card bg-white px-4 pb-4 pt-2 rounded-lg @if($has_shadow=='true') shadow-2xl shadow-gray-200/40 @endif {{$css}}">
    <div class="flex items-start">
        <div><x-bladewind::avatar url="{{$image}}" /></div>
        <div class="pt-1 pl-2 grow">
            <b>{{$name}}</b>
            <div class="text-sm mb-2 @if($department != '' || $position != '') border-b border-gray-100/80 pb-2 @endif">
                {{$position}}
                @if($department != '' && $position != '')
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                @endif
                {{$department}}
            </div>
            <div class="mb-1 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-2 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>{{$mobile}}</div>
            <div class="mb-1 text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-2 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>{!!$email!!}</div>

            {{$slot}}
        </div>
    </div>
</div>
