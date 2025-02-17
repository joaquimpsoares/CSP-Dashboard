@props([
    // name of the input field for use in forms
    'name' => 'textarea-'.uniqid(),
    'rows' => 3,
    'label' => '',
    'required' => 'false',
    'add_clearing' => 'true',
    'placeholder' => '', // placeholder text
    'selected_value' => '', // selected value
    'css' => '',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $required_symbol = ($label == '' && $required == 'true') ? ' *' : '';
    $is_required = ($required == 'true') ? 'required' : '';
    $placeholder_color = ($label !== '') ? 'placeholder-transparent' : '';
@endphp
<div class="relative w-full @if($add_clearing == 'true') mb-2 @endif">
    <textarea {{ $attributes->merge(['class' => "bw-input w-full border border-slate-300/50 dark:border-slate-700 dark:bg-gray-700/90 dark:focus:border-slate-900 peer $is_required $name $css $placeholder_color"]) }} 
        id="{{ $name }}" 
        name="{{ $name }}" 
        placeholder="{{ ($label !== '') ? $label : $placeholder }}{{$required_symbol}}">{{ $selected_value }}</textarea>
    @if($label !== '')
        <label for="{{ $name }}" class="form-label bg-white text-blue-900/40 dark:bg-gray-700/90 dark:text-gray-400" onclick="dom_el('.{{$name}}').focus()">{{ $label }} 
            @if($required == 'true') <span class="text-red-400/80" style="zoom:90%"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block -mt-1" viewBox="0 0 20 20" fill="currentColor">
  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
</svg></span>@endif
        </label>
    @endif
</div>