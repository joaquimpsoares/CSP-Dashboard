<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Categories</h2>
            <p class="mt-1 text-sm text-slate-600">Pick a category for {{ ucfirst($vendor) }}.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ '/store/searchstore/'.$vendor .'/'. $category->category }}"
                       class="group rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm hover:bg-white hover:shadow">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                                {{ strtoupper(substr($vendor,0,1)) }}
                            </div>
                            <div>
                                <div class="text-base font-semibold text-slate-900 group-hover:text-primary-700">{{ ucfirst($category->category) }}</div>
                                <div class="mt-1 text-sm text-slate-600">Browse products</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

