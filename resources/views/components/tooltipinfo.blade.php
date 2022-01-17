<span
    x-data="{ tooltip: false }"
    x-on:mouseover="tooltip = true"
    x-on:mouseleave="tooltip = false"
    class="w-5 h-5 ml-2 cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
  <div x-show="tooltip" class="absolute p-2 text-xs text-black transform translate-x-8 -translate-y-8 bg-blue-200 rounded-lg">
     {{$slot}}
  </div>
</span>
