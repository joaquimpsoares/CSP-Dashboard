@extends('layouts.master')
@section('css')

@endsection

@section('content')
<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
@php
$user = Auth::user();
@endphp
<main class="flex flex-1 overflow-hidden bg-white">
    <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="bg-white border-b border-blue-gray-200 xl:hidden">
            <div class="flex items-start max-w-3xl px-4 py-3 mx-auto sm:px-6 lg:px-8">
                <a href="#" class="inline-flex items-center -ml-1 space-x-3 text-sm font-medium text-blue-gray-900">
                    <!-- Heroicon name: solid/chevron-left -->
                    <svg class="w-5 h-5 text-blue-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Settings</span>
                </a>
            </div>
        </nav>

        <div class="flex flex-1 xl:overflow-hidden">
            <!-- Sidebar -->
            @livewire('user.sidebar', ['user' => $user], key($user->id))
            <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
                <div class="p-4 overflow-hidden bg-white">
                    <div class="flex flex-col">
                        <div class="flex flex-col items-center justify-between lg:flex-row">
                            <div class="flex items-center">
                                <h4>{{ ucwords(trans_choice('messages.password', 2)) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-4 card-footer">
                    </div>
                    <div>
                        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
                            <div class="p-4 overflow-hidden bg-white">
                                @livewire('user.security', ['user' => $user], key($user->id))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection


