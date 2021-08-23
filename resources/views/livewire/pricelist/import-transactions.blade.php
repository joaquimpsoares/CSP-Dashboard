<div>
    <x-button.secondary wire:click="$toggle('showModal')" class="flex items-center space-x-2"><x-icon.upload class="text-cool-gray-500"/> <span>Import</span></x-button.secondary>
    <form wire:submit.prevent="import">
        <x-modal.dialog wire:model="showModal">
            <x-slot name="title">Import Transactions</x-slot>

            <x-slot name="content">
                @unless ($upload)
                <div class="flex flex-col items-center justify-center py-12 ">
                    <div class="flex items-center space-x-2 text-xl">
                        <x-icon.upload class="w-8 h-8 text-cool-gray-400" />
                        <x-input.file-upload wire:model="upload" id="upload"><span class="font-bold text-cool-gray-500">CSV File</span></x-input.file-upload>
                    </div>
                    @error('upload') <div class="mt-3 text-sm text-red-500">{{ $message }}</div> @enderror
                </div>
                @else
                <div>
                    <x-input.group for="name" label="name" :error="$errors->first('fieldColumnMap.name')">
                        <x-input.select wire:model="fieldColumnMap.name" id="name">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                            <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="product_sku" label="product_sku" :error="$errors->first('fieldColumnMap.product_sku')">
                        <x-input.select wire:model="fieldColumnMap.product_sku" id="product_sku">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                            <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="price" label="price">
                        <x-input.select wire:model="fieldColumnMap.price" id="price">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                            <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="msrp" label="msrp">
                        <x-input.select wire:model="fieldColumnMap.msrp" id="msrp">
                            <option value="" disabled>Select Column...</option>
                            @foreach ($columns as $column)
                            <option>{{ $column }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Import</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
