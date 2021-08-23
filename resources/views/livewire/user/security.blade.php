<div>
    <main class="flex flex-1 overflow-hidden bg-white">
        <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
            <div class="flex flex-1 xl:overflow-hidden">
                <!-- Sidebar -->
                @livewire('user.sidebar', ['user' => $user], key($user->id))
                <section>
                    <form wire:submit.prevent="saveauth">
                        <div class="px-4 py-6 bg-white sm:p-6">
                            <div>
                                <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Company details</h2>
                                <p class="mt-1 text-sm text-gray-500">Update your Company billing information.</p>
                            </div>
                            <div class="grid grid-cols-4 gap-6 mt-6">
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
                            </div>
                        </div>
                        <div class="flex flex-col py-5 mt-3 mb-3 border-t border-gray-200">
                            <div class="flex self-end">
                                <x-button type="submit" wire:click="saveauth" >
                                    {{ __('Reset Password') }}
                                </x-button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
</div>
