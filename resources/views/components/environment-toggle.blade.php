@php
    $current = session('environment', 'live');
    $isSandbox = $current === 'sandbox';
@endphp

<form method="POST" action="{{ route('environment.switch') }}" class="flex items-center">
    @csrf
    <input type="hidden" name="environment" value="{{ $isSandbox ? 'live' : 'sandbox' }}">

    <button
        type="submit"
        class="relative inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
               border transition-all duration-200 cursor-pointer select-none
               {{ $isSandbox
                   ? 'bg-yellow-50 border-yellow-300 text-yellow-700 hover:bg-yellow-100'
                   : 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100' }}"
        title="Switch to {{ $isSandbox ? 'Live' : 'Sandbox' }}"
    >
        <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75
                         {{ $isSandbox ? 'bg-yellow-400' : 'bg-green-400' }}"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5
                         {{ $isSandbox ? 'bg-yellow-500' : 'bg-green-500' }}"></span>
        </span>
        {{ $isSandbox ? 'SANDBOX' : 'LIVE' }}
    </button>
</form>
