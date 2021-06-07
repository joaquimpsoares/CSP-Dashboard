<div>
    <section>
        <form  wire:submit="getGDPR"  id="gdpr-form" action="/gdpr/download" method="POST">
            <div class="flex flex-wrap mt-5">
                <section>
                    <h2 class="mb-1 text-xl font-bold text-gray-800">{{ucwords(trans_choice('messages.gdpr', 1))}}</h2>
                    <div class="text-sm">General Data Protection Regulation</div>
                    <div class="flex flex-wrap mt-5">
                        <div class="mr-2">
                            <x-label class="sr-only" for="email">{{ucwords(trans_choice('messages.email', 1))}}</x-label>
                            <x-input name="password" type="password" class=" @error('password') is-invalid @enderror" id="password" value=""></x-input>
                        </div>
                        <button class="text-indigo-500 border-gray-200 shadow-sm btn hover:border-gray-300">{{ucwords(trans_choice('messages.download', 1))}}</button>
                    </div>
                </section>
                @csrf
                <div class="col-md-6">
                    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
        </form>
    </section>
</div>
