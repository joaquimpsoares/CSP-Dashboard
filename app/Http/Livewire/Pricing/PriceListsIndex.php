<?php

namespace App\Http\Livewire\Pricing;

use App\Price;
use App\PriceList;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PriceListsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all'; // all|active|archived (archived = deleted_at not null)

    public int $perPage = 20;

    // ── Create price list drawer ─────────────────────────────────────────────
    public bool $showCreateDrawer = false;
    public string $newName = '';
    public string $newDescription = '';
    public string $newCurrency = '';
    public string $newMarket = '';
    public string $newMargin = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->status = 'all';
        $this->resetPage();
    }

    public function getCountsProperty(): array
    {
        return [
            'all' => PriceList::withTrashed()->count(),
            'active' => PriceList::count(),
            'archived' => PriceList::onlyTrashed()->count(),
        ];
    }

    public function getRowsProperty()
    {
        $q = PriceList::query()->withTrashed();

        if ($this->status === 'active') {
            $q->whereNull('deleted_at');
        } elseif ($this->status === 'archived') {
            $q->whereNotNull('deleted_at');
        }

        if (trim($this->search) !== '') {
            $s = trim($this->search);
            $q->where(function (Builder $q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")
                    ->orWhere('id', 'like', "%{$s}%");
            });
        }

        $q->orderByDesc('updated_at');

        return $q->paginate($this->perPage);
    }

    public function pricingCount(int $priceListId): int
    {
        return Price::query()->where('price_list_id', $priceListId)->count();
    }

    // ── Create price list drawer ─────────────────────────────────────────────

    public function openCreateDrawer(): void
    {
        $this->showCreateDrawer = true;
    }

    public function closeCreateDrawer(): void
    {
        $this->showCreateDrawer = false;
        $this->reset(['newName', 'newDescription', 'newCurrency', 'newMarket', 'newMargin']);
    }

    public function createPriceList(): void
    {
        $this->validate([
            'newName'        => 'required|string|min:3',
            'newDescription' => 'nullable|string',
            'newCurrency'    => 'nullable|string|min:2|max:3',
            'newMarket'      => 'nullable|string|min:2',
            'newMargin'      => 'nullable|numeric|min:0|max:100',
        ]);

        $priceList = PriceList::create([
            'name'        => trim($this->newName),
            'description' => trim($this->newDescription) ?: null,
            'currency'    => trim($this->newCurrency) ?: null,
            'market'      => trim($this->newMarket) ?: null,
            'margin'      => $this->newMargin !== '' ? (float) $this->newMargin : null,
        ]);

        $this->closeCreateDrawer();

        $this->redirect(route('pricing.price_lists.show', $priceList->id));
    }

    public function render()
    {
        return view('pricing.price-lists.livewire.index', [
            'priceLists' => $this->rows,
            'counts' => $this->counts,
        ]);
    }
}
