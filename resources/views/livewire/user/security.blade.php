<div>
    <form method="POST" action="{{route('user.generateToken')}}">
        @csrf
        <div class="input-group">
            <input class="form-control" type="text" name="" placeholder="Recipient's text" aria-label="Recipient's " aria-describedby="my-addon">
            <div class="input-group-append">
                <button wire:click.prevent="generateToken" class="input-group-text" id="my-addon">Text</button>
            </div>
        </div>
        {{-- @foreach($user->tokens as $key => $value) --}}
        <x-label>generate token</x-label>
        <x-input wire:model.prevent="token" id="my-input" class="form-control" type="text" name="" />
        {{-- @endforeach --}}
    </form>
</div>
