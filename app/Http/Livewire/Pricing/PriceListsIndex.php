<?php

namespace App\Http\Livewire\Pricing;

use App\Price;
use App\PriceList;
use App\Provider;
use App\Models\Pricing\ProviderPriceListDefault;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PriceListsIndex extends Component
{
    use WithPagination;

    public function mount(): void
    {
        // Defensive reset: Livewire navigate can preserve component state.
        // Index page must never auto-open drawers.
        $this->showCreateDrawer  = false;

        // Pre-populate provider for the create drawer.
        $this->newProviderId = Auth::user()->provider?->id ?? null;
    }

    public string $search = '';
    public string $status = 'all'; // all|active|archived (archived = deleted_at not null)

    public int $perPage = 20;

    // ── Create price list drawer ─────────────────────────────────────────────
    public bool    $showCreateDrawer        = false;
    public ?int    $newProviderId           = null;
    public string  $newName                 = '';
    public string  $newDescription          = '';
    public string  $newListType             = '';
    public string  $newCurrency             = '';
    public string  $newMarket               = '';
    public string  $newMargin               = '';
    public bool    $newSetAsProviderDefault = false;

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

    // ── Computed: available providers for the create drawer ──────────────────

    public function getProvidersProperty()
    {
        $user = Auth::user();

        if ($user->userLevel->name === config('app.provider')) {
            // Provider users can only assign to their own provider.
            return Provider::where('id', $user->provider->id)->get();
        }

        // Super-admin (or any other elevated level) sees all providers.
        return Provider::orderBy('company_name')->get();
    }

    // ── Computed: paginated rows ─────────────────────────────────────────────

    public function getCountsProperty(): array
    {
        return [
            'all'      => PriceList::withTrashed()->count(),
            'active'   => PriceList::count(),
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
        $this->reset([
            'newName', 'newDescription', 'newListType',
            'newCurrency', 'newMarket', 'newMargin',
            'newSetAsProviderDefault',
        ]);
        // Re-seed provider after reset so it's always pre-populated.
        $this->newProviderId = Auth::user()->provider?->id ?? null;
    }

    public function createPriceList(): void
    {
        $this->validate([
            'newProviderId'           => 'required|integer|exists:providers,id',
            'newName'                 => 'required|string|min:3',
            'newDescription'          => 'nullable|string',
            'newListType'             => ['nullable', 'string', 'in:' . implode(',', array_keys(PriceList::listTypes()))],
            'newCurrency'             => 'nullable|string|min:2|max:3',
            'newMarket'               => 'nullable|string|min:2',
            'newMargin'               => 'nullable|numeric|min:0|max:100',
            'newSetAsProviderDefault' => 'boolean',
        ]);

        $priceList = PriceList::create([
            'provider_id' => $this->newProviderId,
            'name'        => trim($this->newName),
            'description' => trim($this->newDescription) ?: null,
            'list_type'   => $this->newListType ?: null,
            'currency'    => trim($this->newCurrency) ?: null,
            'market'      => trim($this->newMarket) ?: null,
            'margin'      => $this->newMargin !== '' ? (float) $this->newMargin : null,
        ]);

        if ($this->newSetAsProviderDefault) {
            ProviderPriceListDefault::create([
                'provider_id'   => $priceList->provider_id,
                'price_list_id' => $priceList->id,
                'market'        => $priceList->market,
                'currency'      => $priceList->currency,
                'list_type'     => $priceList->list_type,
                'is_default'    => false,
            ])->setAsDefault();
        }

        $this->closeCreateDrawer();

        $this->redirect(route('pricing.price_lists.show', $priceList->id));
    }

    public function render()
    {
        return view('pricing.price-lists.livewire.index', [
            'priceLists' => $this->rows,
            'counts'     => $this->counts,
            'providers'  => $this->providers,
            'listTypes'  => PriceList::listTypes(),
        ]);
    }
}
