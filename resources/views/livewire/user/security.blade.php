<div>
    {{-- @dd(get_defined_vars()) --}}
    <form wire:submit.prevent="saveauth">
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('Password') }}
            </label>
            <div class="mt-1">
                <input wire:model="password"  type="password" autocomplete="current-password" required
                class="@error('password') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>
        </div>
        <div>
            <label for="password-confirm" class="block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <div class="mt-1">
                <input wire:model="password_confirmation" type="password" autocomplete="current-password" required
                class="@error('password') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
            </div>
        </div>
        <div>
            <button type="submit" wire:click="saveauth" class="flex justify-center w-full px-4 py-2 mt-5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
    {{-- <form method="POST" action="{{route('user.generateToken')}}">
        @csrf
        <div class="mt-10 input-group">
            <input class="form-control" type="text" name="" placeholder="Recipient's text" aria-label="Recipient's " aria-describedby="my-addon">
            <div class="input-group-append">
                <button wire:click.prevent="generateToken" class="input-group-text" id="my-addon">Text</button>
            </div>
        </div>
        <x-label>generate token</x-label>
        <x-input wire:model.prevent="token" id="my-input" class="form-control" type="text" name="" />

    </form> --}}
</div>
