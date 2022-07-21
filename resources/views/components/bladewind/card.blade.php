@props([
'title' => '',
'subtitle' => '',
'css' => '',
'has_shadow' => 'true',
'footer' => '',
'button' => '',
'button_function' => '',
'url' => '',
])

<div class="@if($has_shadow=='true')shadow @endif {{$css}} mb-4 overflow-hidden bg-white sm:rounded-lg">
    <div class="px-4 py-3 bg-white border-b border-gray-200 sm:px-6">
        <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
            <div class="mt-2 ml-4">
                @if($title !== '')
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $title}}</h3>
                @if($subtitle !== '')
                <span class="flex items-center text-sm font-medium text-gray-500 capitalize sm:mr-6 sm:mt-0">
                    {{ $subtitle }}
                    <a  class="text-sm text-gray-500 " href="{{$url}}">
                        <x-icon.external class="flex-shrink-0 w-5 h-5 text-gray-400"></x-icon.external>
                    </a>
                </span>
                @endif
                @endif
            </div>
            @if($button !== '')
            <div class="flex-shrink-0 mt-2 ml-4">
                <button type="button"  wire:click={{$button_function}} class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $button}}
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $slot }}
    </div>
    @if($footer != '')
    <div class="border-t border-gray-100/30">
        {{$footer}}
    </div>
    @endif
</div>
