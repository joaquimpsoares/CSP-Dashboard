@extends('layouts.master')
@section('css')

@endsection
@section('content')

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
            <!-- Panel -->
            <div class="flex-grow">
                <!-- Panel body -->
                <div class="p-6 space-y-6">
                    <section>
                        <div class="pt-6 divide-y divide-gray-200">
                            <div class="px-4 sm:px-6">
                                <div>
                                    <h2 class="text-lg font-medium leading-6 text-gray-900">{{ucwords(trans_choice('messages.instance', 2))}}</h2>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ucwords(trans_choice('descriptions.manage_instances', 1))}}
                                    </p>
                                </div>
                                <div class="row">
                                    <div>
                                        <ul class="grid grid-cols-1 gap-5 mt-3 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                            @forelse ($instances as $instance)
                                            <li class="flex col-span-1 rounded-md shadow-sm">
                                                <div class="flex items-center justify-center flex-shrink-0 w-16 text-sm font-medium text-white bg-green-600 rounded-l-md">
                                                    <svg class="w-5 h-5" enable-background="new 0 0 2499.6 2500" viewBox="0 0 2499.6 2500" xmlns="http://www.w3.org/2000/svg"><path d="m1187.9 1187.9h-1187.9v-1187.9h1187.9z" fill="#f1511b"/><path d="m2499.6 1187.9h-1188v-1187.9h1187.9v1187.9z" fill="#80cc28"/><path d="m1187.9 2500h-1187.9v-1187.9h1187.9z" fill="#00adef"/><path d="m2499.6 2500h-1188v-1187.9h1187.9v1187.9z" fill="#fbbc09"/></svg>
                                                </div>
                                                <div class="flex items-center justify-between flex-1 truncate bg-white border-t border-b border-r border-gray-200 rounded-r-md">
                                                    <div class="flex-1 px-4 py-2 text-sm truncate">
                                                        <a href="{{ route('instances.edit', $instance->id) }}" class="font-medium text-gray-900 hover:text-gray-600">{{$instance['name']}}</a>
                                                    </div>
                                                    <div class="flex-shrink-0 pr-2">
                                                        {{-- <div class="z-10"> --}}
                                                            <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {{-- <a wire:click="edit({{ $customer->id }})" class="dropdown-item" href="#"> --}}
                                                                    <x-icon.download></x-icon.download>
                                                                    {{ ucwords(trans_choice('messages.import', 1)) }}
                                                                {{-- </a> --}}
                                                                {{-- @canImpersonate
                                                                @if(!empty($customer->format()['mainUser']))
                                                                <a class="dropdown-item" href="{{ route('impersonate', $customer->format()['mainUser']['id'])}}">
                                                                    <x-icon.impersonate></x-icon.impersonate>
                                                                    {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                                                </a>
                                                                @endif
                                                                @endCanImpersonate --}}
                                                            {{-- </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @empty
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
