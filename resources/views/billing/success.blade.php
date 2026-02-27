<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto text-center">
            <svg class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Subscription activated!</h1>
            <p class="mt-2 text-gray-600">Your CSP Dashboard plan is now active. It may take a few seconds for your account to reflect the change.</p>
            <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Go to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
