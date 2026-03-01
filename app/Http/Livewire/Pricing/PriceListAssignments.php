<?php

namespace App\Http\Livewire\Pricing;

use App\PriceList;
use App\Reseller;
use App\Customer;
use App\Models\Pricing\ResellerPriceListAssignment;
use App\Models\Pricing\CustomerPriceListAssignment;
use Livewire\Component;

class PriceListAssignments extends Component
{
    // ── Props ────────────────────────────────────────────────────────────────

    public int $priceListId;

    // ── Tab state ────────────────────────────────────────────────────────────

    public string $tab = 'resellers'; // resellers|customers

    // ── Assign-reseller drawer ───────────────────────────────────────────────

    public bool    $showResellerDrawer     = false;
    public ?int    $assignResellerId       = null;
    public ?string $assignResellerMarket   = null;
    public ?string $assignResellerCurrency = null;
    public ?string $assignResellerListType = null;

    // ── Assign-customer drawer ───────────────────────────────────────────────

    public bool    $showCustomerDrawer     = false;
    public ?int    $assignCustomerId       = null;
    public ?string $assignCustomerMarket   = null;
    public ?string $assignCustomerCurrency = null;
    public ?string $assignCustomerListType = null;

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(int $priceListId): void
    {
        $this->priceListId = $priceListId;

        // Seed defaults from the price list so users don't have to retype.
        $pl = PriceList::withoutGlobalScopes()->findOrFail($priceListId);
        $this->assignResellerMarket   = $pl->market    ?: null;
        $this->assignResellerCurrency = $pl->currency  ?: null;
        $this->assignResellerListType = $pl->list_type ?: null;
        $this->assignCustomerMarket   = $pl->market    ?: null;
        $this->assignCustomerCurrency = $pl->currency  ?: null;
        $this->assignCustomerListType = $pl->list_type ?: null;
    }

    // ── Computed properties ──────────────────────────────────────────────────

    public function getResellerAssignmentsProperty()
    {
        return ResellerPriceListAssignment::with('reseller')
            ->where('price_list_id', $this->priceListId)
            ->where('is_default', true)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function getCustomerAssignmentsProperty()
    {
        return CustomerPriceListAssignment::with(['customer', 'reseller'])
            ->where('price_list_id', $this->priceListId)
            ->where('is_default', true)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /** Resellers not yet assigned to this price list as default. */
    public function getAvailableResellersProperty()
    {
        $assigned = ResellerPriceListAssignment::where('price_list_id', $this->priceListId)
            ->where('is_default', true)
            ->pluck('reseller_id');

        return Reseller::withoutGlobalScopes()->whereNotIn('id', $assigned)
            ->orderBy('company_name')
            ->get(['id', 'company_name']);
    }

    /** Customers not yet assigned to this price list as default. */
    public function getAvailableCustomersProperty()
    {
        $assigned = CustomerPriceListAssignment::where('price_list_id', $this->priceListId)
            ->where('is_default', true)
            ->pluck('customer_id');

        return Customer::withoutGlobalScopes()->whereNotIn('id', $assigned)
            ->orderBy('company_name')
            ->get(['id', 'company_name']);
    }

    public function getListTypesProperty(): array
    {
        return PriceList::listTypes();
    }

    // ── Reseller drawer ──────────────────────────────────────────────────────

    public function openResellerDrawer(): void
    {
        $this->showResellerDrawer = true;
    }

    public function closeResellerDrawer(): void
    {
        $this->showResellerDrawer = false;
        $this->reset(['assignResellerId']);
        // Re-seed from price list
        $pl = PriceList::withoutGlobalScopes()->find($this->priceListId);
        $this->assignResellerMarket   = $pl?->market    ?: null;
        $this->assignResellerCurrency = $pl?->currency  ?: null;
        $this->assignResellerListType = $pl?->list_type ?: null;
    }

    public function assignReseller(): void
    {
        $this->validate([
            'assignResellerId'     => 'required|integer|exists:resellers,id',
            'assignResellerMarket' => 'nullable|string|min:2',
            'assignResellerCurrency' => 'nullable|string|min:2|max:3',
            'assignResellerListType' => ['nullable', 'string', 'in:' . implode(',', array_keys(PriceList::listTypes()))],
        ]);

        $pl = PriceList::withoutGlobalScopes()->findOrFail($this->priceListId);

        $record = ResellerPriceListAssignment::firstOrCreate(
            [
                'reseller_id'   => $this->assignResellerId,
                'provider_id'   => $pl->provider_id,
                'price_list_id' => $this->priceListId,
                'market'        => $this->assignResellerMarket ?: null,
                'currency'      => $this->assignResellerCurrency ?: null,
                'list_type'     => $this->assignResellerListType ?: null,
            ],
            ['is_default' => false]
        );

        $record->setAsDefault();

        $this->closeResellerDrawer();
        $this->notify('Reseller assignment saved.');
    }

    public function removeResellerAssignment(int $id): void
    {
        ResellerPriceListAssignment::findOrFail($id)->delete();
        $this->notify('Reseller assignment removed.');
    }

    // ── Customer drawer ──────────────────────────────────────────────────────

    public function openCustomerDrawer(): void
    {
        $this->showCustomerDrawer = true;
    }

    public function closeCustomerDrawer(): void
    {
        $this->showCustomerDrawer = false;
        $this->reset(['assignCustomerId']);
        $pl = PriceList::withoutGlobalScopes()->find($this->priceListId);
        $this->assignCustomerMarket   = $pl?->market    ?: null;
        $this->assignCustomerCurrency = $pl?->currency  ?: null;
        $this->assignCustomerListType = $pl?->list_type ?: null;
    }

    public function assignCustomer(): void
    {
        $this->validate([
            'assignCustomerId'      => 'required|integer|exists:customers,id',
            'assignCustomerMarket'  => 'nullable|string|min:2',
            'assignCustomerCurrency'=> 'nullable|string|min:2|max:3',
            'assignCustomerListType'=> ['nullable', 'string', 'in:' . implode(',', array_keys(PriceList::listTypes()))],
        ]);

        $pl = PriceList::withoutGlobalScopes()->findOrFail($this->priceListId);
        $customer = Customer::findOrFail($this->assignCustomerId);

        // Try to find the customer's primary reseller for this provider.
        // Qualify the column to avoid ambiguity with the pivot table.
        $resellerId = $customer->resellers()
            ->where('resellers.provider_id', $pl->provider_id)
            ->value('resellers.id');

        $record = CustomerPriceListAssignment::firstOrCreate(
            [
                'customer_id'   => $this->assignCustomerId,
                'provider_id'   => $pl->provider_id,
                'price_list_id' => $this->priceListId,
                'market'        => $this->assignCustomerMarket ?: null,
                'currency'      => $this->assignCustomerCurrency ?: null,
                'list_type'     => $this->assignCustomerListType ?: null,
            ],
            [
                'reseller_id' => $resellerId,
                'is_default'  => false,
            ]
        );

        $record->setAsDefault();

        $this->closeCustomerDrawer();
        $this->notify('Customer assignment saved.');
    }

    public function removeCustomerAssignment(int $id): void
    {
        CustomerPriceListAssignment::findOrFail($id)->delete();
        $this->notify('Customer assignment removed.');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function notify(string $message): void
    {
        $this->dispatch('notify', ['message' => $message]);
    }

    // ── Render ───────────────────────────────────────────────────────────────

    public function render()
    {
        return view('pricing.price-lists.livewire.partials.assignments', [
            'resellerAssignments' => $this->resellerAssignments,
            'customerAssignments' => $this->customerAssignments,
            'availableResellers'  => $this->availableResellers,
            'availableCustomers'  => $this->availableCustomers,
            'listTypes'           => $this->listTypes,
        ]);
    }
}
