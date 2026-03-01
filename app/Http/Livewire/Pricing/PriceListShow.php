<?php

namespace App\Http\Livewire\Pricing;

use App\PriceList;
use App\Product;
use App\Models\Pricing\PriceListItem;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class PriceListShow extends Component
{
    use WithPagination;

    public PriceList $priceList;

    public string $tab = 'all'; // all|legacy|perpetual|nce
    public string $search = '';
    public int $perPage = 25;

    // Edit price list modal
    public bool $showEditPriceListModal = false;
    public string $priceListStatus = 'active'; // active|draft|archived

    // bulk
    public array $selected = [];
    public bool $selectPage = false;

    // price editor modal state
    public bool $showPriceModal = false;
    public ?int $editingPriceId = null;

    protected $queryString = [
        'tab' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'priceSaved' => 'refreshPrices',
        'closePriceEditor' => 'closePriceModal',
    ];

    public function mount(int $id): void
    {
        $this->priceList = PriceList::withTrashed()->findOrFail($id);

        // Defensive reset: Livewire navigate can preserve component state across navigations.
        // Show page must never auto-open drawers.
        $this->showPriceModal = false;
        $this->editingPriceId = null;
        $this->showEditPriceListModal = false;

        $this->priceListStatus = $this->priceList->deleted_at
            ? 'archived'
            : ((empty($this->priceList->effective_from) && empty($this->priceList->effective_to)) ? 'draft' : 'active');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function refreshPrices(): void
    {
        $this->resetPage();
    }

    public function openCreatePriceModal(): void
    {
        $this->editingPriceId = null;
        $this->showPriceModal = true;
    }

    public function openEditPriceModal(int $priceId): void
    {
        $this->editingPriceId = $priceId;
        $this->showPriceModal = true;
    }

    public function closePriceModal(): void
    {
        $this->showPriceModal = false;
        $this->editingPriceId = null;
    }

    public function toggleAvailability(bool $value): void
    {
        if (empty($this->selected)) {
            return;
        }

        $items = PriceListItem::query()->whereIn('id', $this->selected)->get();
        foreach ($items as $it) {
            $it->available_for_purchase = $value;
            $it->save();
        }

        $this->selected = [];
        $this->selectPage = false;
    }

    public function deleteSelected(): void
    {
        if (empty($this->selected)) {
            return;
        }

        PriceListItem::query()->whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectPage = false;

        $this->resetPage();
    }

    public function openEditPriceListModal(): void
    {
        // Re-evaluate status each time in case the record changed.
        $this->priceListStatus = $this->priceList->deleted_at
            ? 'archived'
            : ((empty($this->priceList->effective_from) && empty($this->priceList->effective_to)) ? 'draft' : 'active');

        $this->showEditPriceListModal = true;
    }

    public function closeEditPriceListModal(): void
    {
        $this->showEditPriceListModal = false;
    }

    public function savePriceList(): void
    {
        $this->validate([
            'priceList.name' => 'required|string|min:3',
            'priceList.description' => 'nullable|string',
            'priceList.margin' => 'nullable|numeric|min:0',
            'priceList.market' => 'nullable|string|min:2',
            'priceList.currency' => 'nullable|string|min:2',
            'priceList.effective_from' => 'nullable|date',
            'priceList.effective_to' => 'nullable|date|after_or_equal:priceList.effective_from',
            'priceListStatus' => 'required|in:active,draft,archived',
        ]);

        // Status mapping:
        // - archived => soft delete
        // - active/draft => restore if needed (draft is a UX state; record remains usable)
        if ($this->priceListStatus === 'archived') {
            if (!$this->priceList->deleted_at) {
                $this->priceList->delete();
                $this->priceList->refresh();
            }
        } else {
            if ($this->priceList->deleted_at) {
                $this->priceList->restore();
                $this->priceList->refresh();
            }

            $this->priceList->save();
        }

        $this->showEditPriceListModal = false;
    }

    public function getPricesProperty()
    {
        $q = PriceListItem::query()
            ->where('price_list_id', $this->priceList->id)
            ->with(['product']);

        // tab filters based on related Product fields
        if ($this->tab === 'legacy') {
            $q->whereHas('product', fn (Builder $p) => $p->where('productType', 'Legacy'));
        } elseif ($this->tab === 'perpetual') {
            $q->whereHas('product', fn (Builder $p) => $p->where('is_perpetual', true));
        } elseif ($this->tab === 'nce') {
            $q->whereHas('product', fn (Builder $p) => $p->where('productType', 'OnlineServicesNCE'));
        }

        if (trim($this->search) !== '') {
            $s = trim($this->search);
            $q->where(function (Builder $q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('sku', 'like', "%{$s}%")
                    ->orWhere('offer_id', 'like', "%{$s}%")
                    ->orWhere('sku_id', 'like', "%{$s}%");
            });
        }

        $q->orderBy('title');

        return $q->paginate($this->perPage);
    }

    public function render()
    {
        return view('pricing.price-lists.livewire.show', [
            'prices' => $this->prices,
        ]);
    }
}
