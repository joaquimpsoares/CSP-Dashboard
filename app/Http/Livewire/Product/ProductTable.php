<?php

namespace App\Http\Livewire\Product;

use App\Country;
use App\Instance;
use App\PriceList;
use App\Product;
use App\Provider;
use App\Exports\ProductsExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Traits\UserTrait;
use App\Services\Pricing\PriceContext;
use App\Services\Pricing\PricingEngine;
use App\Jobs\BulkAddProductsToPriceListJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ProductTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public $license = false;
    public $perpetual = false;
    public $showDeleteModal = false;
    public $showImportModal = false;

    public string $statusFilter = 'all'; // all|active|archived

    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    public bool $bulkDisabled = true;

    // Bulk add to price list (Stripe drawer)
    public bool $showBulkAddToPriceList = false;
    public ?int $targetPriceListId = null;
    public string $bulkPricingRule = 'copy_msrp'; // copy_msrp|margin_percent|fixed
    public ?float $bulkMarginPercent = null;
    public ?string $bulkFixedPrice = null;
    public bool $bulkAvailability = true;
    public array $bulkResult = [];

    // pricing preview context
    public ?int $providerId = null;
    public ?int $resellerId = null;
    public ?string $market = null;
    public ?string $currency = null;
    protected ?int $priceListId = null;

    /** @var array<int, array<string,mixed>> keyed by product id */
    public array $pricePreview = [];

    public function mount(): void
    {
        $user = $this->getUser();
        $provider = $user?->provider ?? $user?->reseller?->provider;

        $this->providerId = $provider?->id;
        $this->resellerId = $user?->reseller?->id;

        $pl = null;
        if ($this->providerId) {
            $pl = PriceList::query()
                ->where('provider_id', $this->providerId)
                ->where('source', 'microsoft_partnercenter')
                ->orderByDesc('effective_from')
                ->orderByDesc('id')
                ->first();
        }

        $this->priceListId = $pl?->id;
        $this->market = $pl?->market ?? 'ES';
        $this->currency = $pl?->currency ?? 'EUR';
    }

    public function updatingFilters(): void
    {
        $this->resetPage();
    }

    public function setStatusFilter(string $filter): void
    {
        if (!in_array($filter, ['all', 'active', 'archived'], true)) {
            return;
        }
        $this->statusFilter = $filter;
        $this->resetPage();
    }

    public function import(): void
    {
        $this->showImportModal = true;
    }

    public function deleteSelected(): void
    {
        $deleteCount = $this->selectedRowsQuery->count();
        foreach ($this->selectedRowsQuery->get() as $row) {
            if ($row->hasPrice() != null) {
                $product = $row->name;
                $this->notify('', 'This Product ' . $product . ' has a price associated, cannot be deleted', 'error');
                $this->showDeleteModal = false;
                return;
            }

            $this->selectedRowsQuery->delete();
            $this->showDeleteModal = false;
        }
        $this->notify("You've deleted {$deleteCount} Product");
    }

    public function archive(int $id): void
    {
        Product::query()->findOrFail($id)->delete();
        $this->notify('', 'Product archived', 'success');
    }

    public function restore(int $id): void
    {
        Product::withTrashed()->findOrFail($id)->restore();
        $this->notify('', 'Product restored', 'success');
    }

    public function forceDelete(int $id): void
    {
        Product::withTrashed()->findOrFail($id)->forceDelete();
        $this->notify('', 'Product deleted', 'success');
    }

    public function openBulkAddToPriceList(): void
    {
        $this->bulkResult = [];
        $this->showBulkAddToPriceList = true;

        // Default: provider's latest manual price list (fallback to any)
        if (!$this->targetPriceListId && $this->providerId) {
            $pl = PriceList::query()
                ->where('provider_id', $this->providerId)
                ->orderByDesc('effective_from')
                ->orderByDesc('id')
                ->first();
            $this->targetPriceListId = $pl?->id;
        }
    }

    public function closeBulkAddToPriceList(): void
    {
        $this->showBulkAddToPriceList = false;
    }

    public function executeBulkAddToPriceList(): void
    {
        if (empty($this->selected)) {
            $this->bulkResult = ['error' => 'No products selected'];
            return;
        }

        $this->validate([
            'targetPriceListId' => 'required|integer|exists:price_lists,id',
            'bulkPricingRule' => 'required|in:copy_msrp,margin_percent,fixed',
            'bulkMarginPercent' => 'nullable|numeric|min:0',
            'bulkFixedPrice' => 'nullable|numeric|min:0',
            'bulkAvailability' => 'boolean',
        ]);

        $ids = array_map('intval', $this->selected);

        if (count($ids) > 200) {
            BulkAddProductsToPriceListJob::dispatch(
                (int) $this->targetPriceListId,
                $ids,
                $this->bulkPricingRule,
                $this->bulkMarginPercent,
                $this->bulkFixedPrice,
                (bool) $this->bulkAvailability,
            );

            $this->bulkResult = ['queued' => true, 'count' => count($ids)];
            $this->showBulkAddToPriceList = false;
            $this->selected = [];
            $this->selectPage = false;
            return;
        }

        $job = new BulkAddProductsToPriceListJob(
            (int) $this->targetPriceListId,
            $ids,
            $this->bulkPricingRule,
            $this->bulkMarginPercent,
            $this->bulkFixedPrice,
            (bool) $this->bulkAvailability,
        );
        $res = $job->handle();

        $this->bulkResult = $res;
        $this->showBulkAddToPriceList = false;
        $this->selected = [];
        $this->selectPage = false;
    }

    public function importproducts(): void
    {
        if (!Auth::user()->provider) {
            abort(403, 'You do not have permission to perform this action.');
        }

        if ($this->license === true) {
            Log::info('Started importing NCE');

            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importNCELicenses($instance, $country);
        }

        if ($this->perpetual === true) {
            Log::info('Started importing Perpetual');

            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importPerpetual($instance, $country);

            $this->notify('Perpetual Software has been scheduled for import');
        }

        $this->showImportModal = false;
    }

    public function getRowsQueryProperty()
    {
        $q = Product::query();

        if ($this->statusFilter === 'archived') {
            $q->onlyTrashed();
        } elseif ($this->statusFilter === 'all') {
            $q->withTrashed();
        }

        $search = (string)($this->filters['search'] ?? '');
        if ($search !== '') {
            $q->where(function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('billing', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $q->with(['instance']);

        return $this->applySorting($q);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function exportSelected()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    /**
     * Compute sell_unit preview for a product SKU (reseller context if available).
     */
    protected function computePreview(PricingEngine $engine, Product $product): ?array
    {
        if (!$this->providerId) {
            return null;
        }
        if (!$product->sku) {
            return null;
        }

        // Guess product type
        $pt = 'license';
        if (!empty($product->category) && str_contains(strtolower($product->category), 'azure')) {
            $pt = 'azure';
        }

        $ctx = new PriceContext(
            providerId: (int) $this->providerId,
            resellerId: $this->resellerId,
            customerId: null,
            subscriptionId: null,
            market: $this->market ?? 'ES',
            currency: $this->currency ?? 'EUR',
            productType: $pt,
            offerId: null,
            skuId: (string) $product->sku,
            meterId: null,
            productFamily: null,
            category: null,
            tags: [],
            billingCycle: null,
            term: $product->term ? (string) $product->term : null,
            quantity: 1,
        );

        $res = $engine->quoteLine($ctx);
        if (!$res->ok) {
            return ['ok' => false, 'reason' => $res->reason];
        }

        return [
            'ok' => true,
            'sell_unit' => $res->outputs['sell_unit'] ?? null,
            'reason' => $res->selectionReason,
        ];
    }

    public function render(PricingEngine $engine)
    {
        // Compute previews for current page rows (cached per request)
        foreach ($this->rows as $p) {
            if (!isset($this->pricePreview[$p->id])) {
                $this->pricePreview[$p->id] = $this->computePreview($engine, $p) ?? ['ok' => false, 'reason' => 'NO_CONTEXT'];
            }
        }

        $allCount = Product::withTrashed()->count();
        $activeCount = Product::count();
        $archivedCount = Product::onlyTrashed()->count();

        return view('livewire.product.product-table', [
            'products' => $this->rows,
            'counts' => [
                'all' => $allCount,
                'active' => $activeCount,
                'archived' => $archivedCount,
            ],
        ]);
    }
}
