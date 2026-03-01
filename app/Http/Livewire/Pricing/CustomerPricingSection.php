<?php

namespace App\Http\Livewire\Pricing;

use App\PriceList;
use App\Models\Pricing\CustomerPriceListAssignment;
use Livewire\Component;

/**
 * Read-only panel shown on the Customer show page.
 * Displays which price lists are set as defaults for this customer.
 */
class CustomerPricingSection extends Component
{
    public int $customerId;

    public function getAssignmentsProperty()
    {
        return CustomerPriceListAssignment::with(['priceList', 'reseller'])
            ->where('customer_id', $this->customerId)
            ->where('is_default', true)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function getListTypesProperty(): array
    {
        return PriceList::listTypes();
    }

    public function render()
    {
        return view('pricing.price-lists.livewire.partials.customer-pricing-section', [
            'assignments' => $this->assignments,
            'listTypes'   => $this->listTypes,
        ]);
    }
}
