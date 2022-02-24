@extends('layouts.master2')
@section('css')
@endsection
@section('content')

<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
            Sign in to your account
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6"action="{{ route('login') }}" action="#" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required class="@error('email') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="@error('email') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('password') <span class="invalid-feedback" role="alert"> strong>{{ $message }}</strong> </span> @enderror

                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember_me" class="block ml-2 text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>
                <div>
                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-gray-500 bg-white">
                            Or continue with
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mt-6">
                    <div>
                    </div>
                    <div>
                        <a href="/login/microsoft" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <span class="sr-only">Sign in with Microsoft</span>
                            <svg class="w-25 h-25" xmlns="http://www.w3.org/2000/svg" fill="currentColor"  enable-background="new 0 0 2499.6 2500" viewBox="0 0 2499.6 2500">
                                <path d="m1187.9 1187.9h-1187.9v-1187.9h1187.9z"/>
                                <path d="m2499.6 1187.9h-1188v-1187.9h1187.9v1187.9z"/>
                                <path d="m1187.9 2500h-1187.9v-1187.9h1187.9z"/>
                                <path d="m2499.6 2500h-1188v-1187.9h1187.9v1187.9z"/>
                            </svg>
                        </a>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    if(window.location.href.endsWith('login#')){
        window.location.href = '/home';
    }
</script>
@endsection

