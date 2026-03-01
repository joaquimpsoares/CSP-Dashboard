<form wire:submit.prevent="savePricelist">
    <x-modal.dialog wire:model.defer="showEditPricelistModal">
        <x-slot name="title">Edit price list</x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <x-input.group for="pl_name" label="Name" :error="$errors->first('editingPricelist.name')">
                    <x-input.text id="pl_name" wire:model.defer="editingPricelist.name" />
                </x-input.group>

                <x-input.group for="pl_description" label="Description" :error="$errors->first('editingPricelist.description')">
                    <x-input.text id="pl_description" wire:model.defer="editingPricelist.description" />
                </x-input.group>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-input.group for="pl_market" label="Market" :error="$errors->first('editingPricelist.market')">
                        <x-input.text id="pl_market" wire:model.defer="editingPricelist.market" placeholder="ES" />
                    </x-input.group>

                    <x-input.group for="pl_currency" label="Currency" :error="$errors->first('editingPricelist.currency')">
                        <x-input.text id="pl_currency" wire:model.defer="editingPricelist.currency" placeholder="EUR" />
                    </x-input.group>

                    <x-input.group for="pl_margin" label="Margin %" :error="$errors->first('editingPricelist.margin')">
                        <x-input.text id="pl_margin" wire:model.defer="editingPricelist.margin" />
                    </x-input.group>

                    <x-input.group for="pl_instance" label="Instance" :error="null">
                        <x-input.text id="pl_instance" value="{{ $priceList->instance_id ?? '—' }}" disabled />
                    </x-input.group>

                    <x-input.group for="pl_from" label="Effective from" :error="$errors->first('editingPricelist.effective_from')">
                        <x-input.text id="pl_from" wire:model.defer="editingPricelist.effective_from" placeholder="YYYY-MM-DD" />
                    </x-input.group>

                    <x-input.group for="pl_to" label="Effective to" :error="$errors->first('editingPricelist.effective_to')">
                        <x-input.text id="pl_to" wire:model.defer="editingPricelist.effective_to" placeholder="YYYY-MM-DD" />
                    </x-input.group>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="submit" class="inline-flex justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">Save</button>
            <button type="button" wire:click="$set('showEditPricelistModal', false)" class="ml-2 inline-flex justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
        </x-slot>
    </x-modal.dialog>
</form>
