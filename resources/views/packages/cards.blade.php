@extends('layouts.master')
@section('css')

@endsection
@section('content')

@php
    $user = Auth::user();
@endphp
<div class="row">
    @livewire('user.sidebar', ['user' => $user], key($user->id))
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div>
        <h2 class="text-xs font-medium tracking-wide text-gray-500 uppercase">Pinned Projects</h2>
        <ul class="grid grid-cols-1 gap-5 mt-3 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse (Auth::user()->provider->instances as $instance)
            <li class="flex col-span-1 rounded-md shadow-sm">
                <div class="flex items-center justify-center flex-shrink-0 w-16 text-sm font-medium text-white bg-green-600 rounded-l-md">
                    <svg class="w-5 h-5" enable-background="new 0 0 2499.6 2500" viewBox="0 0 2499.6 2500" xmlns="http://www.w3.org/2000/svg"><path d="m1187.9 1187.9h-1187.9v-1187.9h1187.9z" fill="#f1511b"/><path d="m2499.6 1187.9h-1188v-1187.9h1187.9v1187.9z" fill="#80cc28"/><path d="m1187.9 2500h-1187.9v-1187.9h1187.9z" fill="#00adef"/><path d="m2499.6 2500h-1188v-1187.9h1187.9v1187.9z" fill="#fbbc09"/></svg>
                </div>
                <div class="flex items-center justify-between flex-1 truncate bg-white border-t border-b border-r border-gray-200 rounded-r-md">
                    <div class="flex-1 px-4 py-2 text-sm truncate">
                        <a href="{{ route('instances.edit', $instance->id) }}" class="font-medium text-gray-900 hover:text-gray-600">{{$instance['name']}}</a>
                    </div>
                    <div class="flex-shrink-0 pr-2">
                        <button class="inline-flex items-center justify-center w-8 h-8 text-gray-400 bg-transparent bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Open options</span>
                            <!-- Heroicon name: solid/dots-vertical -->
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </li>
            @empty
            @endforelse
        </ul>
    </div>
</div>

@endsection
