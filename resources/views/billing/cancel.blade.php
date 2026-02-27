<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto text-center">
            <svg class="mx-auto mb-4 w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Checkout cancelled</h1>
            <p class="mt-2 text-gray-600">No charges were made. You can subscribe any time.</p>
            <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
