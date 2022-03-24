<div>
    <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
        <div class="flex flex-1 xl:overflow-hidden">
            <!-- Sidebar -->
            @livewire('user.sidebar', ['user' => $user], key($user->id))
            <section>
                <form wire:submit.prevent="saveauth">
                    <div class="px-4 py-6 bg-white sm:p-6">
                        <div>
                            <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">User Password</h2>
                            <p class="mt-1 text-sm text-gray-500">Update your user password.</p>
                        </div>
                        <div class="grid grid-cols-4 gap-6 mt-6">
                            <div>
                                <div class="mt-1">
                                    <x-input wire:model="password"  type="password" autocomplete="current-password" required placeholder="Password"
                                    class="@error('password') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400"></x-input>
                                    @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                </div>
                            </div>
                            <div>
                                <div class="mt-1">
                                    <x-input wire:model="password_confirmation" type="password" autocomplete="current-password" required placeholder="Confirm Password"
                                    class="@error('password') is-invalid @enderror block w-full px-3 py-2 placeholder-gray-400"></x-input>
                                    @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                </div>
                            </div>
                            <x-button type="submit" wire:click="saveauth" >
                                {{ __('Reset Password') }}
                            </x-button>
                        </div>
                    </div>
                </form>
                <div class="px-4 py-6 bg-white sm:p-6">
                    <div>
                        <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Create API Token</h2>
                        <p class="mt-1 text-sm text-gray-500">API Tokens allow third-party services to authenticate with our application on your behalf.</p>
                    </div>
                    <div>
                        <div class="flex mt-6 space-x-4" action="#">
                            <div class="flex-1 min-w-0">
                                <label for="search" class="sr-only">Search</label>
                                <div>
                                    <x-input wire:model='name' type="text" name="name" id="name" class="@error('password') is-invalid @enderror  block w-full px-3 py-2 placeholder-gray-400" placeholder="Token Name"></x-input>
                                    @error('name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                </div>
                            </div>
                            <button  wire:click='generateToken' class="inline-flex justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                Generate Token
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                        
                        @if($token)
                        <div class="flex-1 min-w-0 mt-3">
                            <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Token Created</h2>
                            <p class="mt-1 text-sm text-gray-500">Copy this Token, we will not be able to show it again.</p>
                        </div>
                        <div class="flex mt-6 space-x-4" action="#">
                            <div class="flex-1 min-w-0">
                                <x-input wire:model='token' type="search" name="search" id="search" class="" placeholder="Token Name"></x-input>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-8 overflow-hidden bg-white shadow sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($user->tokens as $token)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-indigo-600 truncate">{{$token->name}}</p>
                                        <div class="flex flex-shrink-0 ml-2">
                                            <a href="#" wire:click="deleteToken({{ $token->id }})" class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 ">Delete</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    function copyToClipboard(subscription_id) {
        document.getElementById(subscription_id).select();
        document.execCommand('copy');1
    }
</script>
<script>
    tippy('#myButton', {
        animation: 'fade',
        delay: [0,500],
        trigger: 'click',
        content: "Copied",
    });
</script>