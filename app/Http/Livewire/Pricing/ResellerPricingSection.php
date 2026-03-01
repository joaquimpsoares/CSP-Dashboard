<?php

namespace App\Http\Livewire\Pricing;

use App\PriceList;
use App\Models\Pricing\ResellerPriceListAssignment;
use Livewire\Component;

/**
 * Read-only panel shown on the Reseller show page.
 * Displays which price lists are set as defaults for this reseller.
 */
class ResellerPricingSection extends Component
{
    public int $resellerId;

    public function getAssignmentsProperty()
    {
        return ResellerPriceListAssignment::with('priceList')
            ->where('reseller_id', $this->resellerId)
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
        return view('pricing.price-lists.livewire.partials.reseller-pricing-section', [
            'assignments' => $this->assignments,
            'listTypes'   => $this->listTypes,
        ]);
    }
}
