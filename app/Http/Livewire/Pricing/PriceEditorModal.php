<?php

namespace App\Http\Livewire\Pricing;

use App\PriceList;
use App\Product;
use App\Models\Pricing\PriceListItem;
use Livewire\Component;

class PriceEditorModal extends Component
{
    public bool $open = true;

    public int $priceListId;
    public ?int $priceId = null;

    public string $productQuery = '';
    public array $productResults = [];
    public ?int $productId = null;

    public string $name = '';
    public ?string $description = null;

    public string $currency = 'EUR';
    public string $billingCycle = 'monthly'; // monthly|annual|PAYG|one_time|none
    public ?string $termDuration = 'P1M';
    public ?string $market = null;

    public string $amount = '0.00'; // sell price
    public ?string $msrp = null;

    public bool $available = true;

    public bool $showMoreOptions = false;
    public ?string $vendor = null;
    public ?string $sku = null;
    public ?string $offerId = null;
    public ?string $skuId = null;
    public ?string $meterId = null;

    public int $previewQty = 1;

    protected $listeners = [
        'openPriceEditor' => 'open',
    ];

    public function mount(int $priceListId, ?int $priceId = null): void
    {
        $this->priceListId = $priceListId;
        $this->priceId = $priceId;

        $pl = PriceList::withTrashed()->find($priceListId);
        if ($pl) {
            if (!empty($pl->currency)) $this->currency = $pl->currency;
            $this->market = $pl->market;
        }

        if ($priceId) {
            $this->loadPriceListItem($priceId);
        }
    }

    public function updatedProductQuery(): void
    {
        $q = trim($this->productQuery);
        if (strlen($q) < 2) {
            $this->productResults = [];
            return;
        }

        $res = Product::query()
            ->where(function ($p) use ($q) {
                $p->where('name', 'like', "%{$q}%")
                  ->orWhere('sku', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'sku', 'vendor', 'minimum_quantity', 'maximum_quantity']);

        $this->productResults = $res->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'sku' => $p->sku,
            'vendor' => $p->vendor,
            'minimum_quantity' => $p->minimum_quantity,
            'maximum_quantity' => $p->maximum_quantity,
        ])->toArray();
    }

    public function selectProduct(int $id): void
    {
        $p = Product::withTrashed()->findOrFail($id);
        $this->productId = $p->id;

        // auto-fill mapping fields from Product
        $this->vendor = $p->vendor;
        $this->sku = $p->sku;
        $this->offerId = $p->offer_id;
        $this->skuId = $p->sku_id;
        $this->meterId = $p->meter_id;
        $this->termDuration = $p->default_term_duration ?: ($p->term ?: $this->termDuration);
        $this->billingCycle = $p->default_billing_cycle ?: ($p->billing ?: $this->billingCycle);
        $this->currency = $p->default_currency ?: $this->currency;
        $this->msrp = $p->msrp !== null ? (string) $p->msrp : $this->msrp;

        $this->productQuery = ($p->name ?: '—') . ' · ' . $p->sku;
        $this->productResults = [];

        if ($this->name === '') {
            $this->name = $p->name ?: $this->name;
        }

        $this->available = (bool) $p->is_available_for_purchase;
    }

    public function loadPriceListItem(int $id): void
    {
        $it = PriceListItem::with('product')->findOrFail($id);
        $this->priceId = $it->id;
        $this->productId = $it->product_id;

        $this->vendor = $it->vendor;
        $this->sku = $it->sku;
        $this->offerId = $it->offer_id;
        $this->skuId = $it->sku_id;
        $this->meterId = $it->meter_id;

        $this->name = $it->title ?? '';
        $this->amount = $it->price !== null ? (string) $it->price : '0.00';
        $this->msrp = $it->msrp !== null ? (string) $it->msrp : null;
        $this->currency = $it->currency ?: $this->currency;
        $this->billingCycle = $it->billing_cycle ?: $this->billingCycle;
        $this->termDuration = $it->term_duration ?: ($it->term ?: $this->termDuration);

        $this->available = (bool) $it->available_for_purchase;

        $name = $it->product?->name ?: $it->title;
        $sku = $it->product?->sku ?: $it->sku;
        $this->productQuery = ($name ?: '—') . ' · ' . ($sku ?: '');
    }

    public function open(?int $priceId = null): void
    {
        $this->open = true;
        if ($priceId) {
            $this->loadPriceListItem($priceId);
        }
    }

    public function close(): void
    {
        $this->open = false;
        $this->emitUp('closePriceEditor');
    }

    public function save(): void
    {
        $this->validate([
            'productId' => 'required|integer|exists:products,id',
            'name' => 'required|string|min:3',
            'currency' => 'required|string|min:2',
            'amount' => 'required|numeric|min:0',
            'termDuration' => 'nullable|string',
            'billingCycle' => 'nullable|string',
        ]);

        $pl = PriceList::withTrashed()->findOrFail($this->priceListId);
        $p = Product::withTrashed()->findOrFail($this->productId);

        // Validation: Microsoft rows must have offer mapping
        if (strtolower((string)($this->vendor ?? $p->vendor ?? '')) === 'microsoft' && empty($this->offerId)) {
            $this->addError('offerId', 'This product is missing Microsoft offer mapping.');
            return;
        }

        $attrs = [
            'price_list_id' => $pl->id,
            'product_id' => $p->id,
            'vendor' => $this->vendor ?? $p->vendor,
            'sku' => $this->sku ?? $p->sku,
            'offer_id' => $this->offerId,
            'sku_id' => $this->skuId,
            'meter_id' => $this->meterId,
            'title' => $this->name,
            'billing_cycle' => $this->billingCycle,
            'term_duration' => $this->termDuration,
            'term' => $this->termDuration, // keep legacy term in sync
            'currency' => $this->currency,
            'price' => $this->amount,
            'msrp' => $this->msrp ?? $this->amount,
            'available_for_purchase' => $this->available,

            // Manual/provider rows: cost_unit intentionally left null (per 1B)
            'cost_unit' => null,
        ];

        if ($this->priceId) {
            PriceListItem::query()->where('id', $this->priceId)->update($attrs);
        } else {
            PriceListItem::create($attrs);
        }

        $this->emitUp('priceSaved');
        $this->close();
    }

    public function getPreviewSubtotalProperty(): float
    {
        return (float) $this->amount * max(1, (int) $this->previewQty);
    }

    public function render()
    {
        return view('pricing.price-lists.partials.price-editor-modal');
    }
}
