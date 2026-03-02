<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Customer;
use App\Http\Traits\UserTrait;
use App\Models\Pricing\PriceListItem;
use App\Models\ProductRequest;
use App\PriceList;
use App\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Services\Pricing\PriceListResolver;

class Store extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    protected $paginationTheme = 'bootstrap';

    // ── Core state ────────────────────────────────────────────────────────────
    public $showModal = false;
    public $keyword;
    public $searchproduct = null;

    public $details;
    public $search;
    public $vendor = [];
    public $price;
    public $cartProducts = [];
    public $selectproducttype;
    public $priceList;

    /** @var string|null  Name of the resolved price list (for the store banner). */
    public ?string $resolvedPriceListName = null;

    // ── Filter options ────────────────────────────────────────────────────────
    public $vendors;
    public $categories;
    public $terms;
    public $productType;

    // ── Product detail panel ──────────────────────────────────────────────────
    public $productName;
    public $productCategory;
    public $productSku;
    public $productDescription;
    public $productMSRP;

    public $showmobilefilter = false;
    public $showproductdetails = false;

    // ── Filters ───────────────────────────────────────────────────────────────
    public $filters = [
        'search'      => '',
        'category'    => '',
        'vendors'     => '',
        'producttype' => '',
        'plugins'     => false,
        'billing'     => [],
        'terms'       => [],
        'trial'       => '',
    ];

    // ── Product request modal ─────────────────────────────────────────────────
    public bool    $showRequestModal    = false;
    public ?string $requestProductName  = null;
    public ?string $requestProductSku   = null;
    public ?string $requestNotes        = null;
    public ?string $requestUrgency      = 'normal';

    // ── Lifecycle hooks ───────────────────────────────────────────────────────
    public function updatingSearch()  { $this->resetPage(); }
    public function updatingcategories()  { $this->resetPage(); }
    public function updatingselectproducttype() { $this->resetPage(); }
    public function updatedQtys($field) { $this->recalc($field); }
    public function close() { $this->showModal = false; }

    // ── Add to cart ───────────────────────────────────────────────────────────

    /**
     * Add a PriceListItem to the cart.
     *
     * Server-side enforced: the item must belong to the currently resolved
     * price list AND have available_for_purchase = true.
     */
    public function addToCart(int $priceListItemId): void
    {
        $this->showModal = false;

        // Re-resolve to prevent tampering between page load and click.
        $currentPriceListId = $this->resolveUserPriceListId();

        if ($currentPriceListId === null) {
            $this->notify('No active price list is assigned to your account.');
            return;
        }

        $item = PriceListItem::query()
            ->where('id', $priceListItemId)
            ->where('price_list_id', $currentPriceListId)
            ->where('available_for_purchase', true)
            ->with('product')
            ->first();

        if (! $item) {
            $this->notify('This product is not available for purchase in your current price list.');
            return;
        }

        $product = $item->product;
        if (! $product) {
            $this->notify('Product data is missing. Please contact your provider.');
            return;
        }

        $cart = $this->getUserCart();
        if (! $cart) {
            $cart = new Cart();
            $cart->save();
        }

        $billingCycle  = $item->billing_cycle ?? 'monthly';
        $termDuration  = $item->term_duration;

        $cart->products()->attach($product->id, [
            'id'                => Str::uuid(),
            'price'             => $item->price,
            'retail_price'      => $item->msrp,
            'quantity'          => $product->minimum_quantity ?? 1,
            'billing_cycle'     => $billingCycle,
            'term_duration'     => $termDuration,
            'price_list_item_id'=> $item->id,
            'currency'          => $item->currency,
        ]);

        $this->emit('updateCart');
        $this->notify('Product added to cart: ' . $product->name);
    }

    // ── Product detail panel ──────────────────────────────────────────────────

    public function showDetails(int $priceListItemId): void
    {
        $item = PriceListItem::with('product')->find($priceListItemId);
        if (! $item) {
            return;
        }

        $this->showproductdetails = true;
        $this->price              = $item;   // used in the detail modal
        $this->retail             = $item->price;
        $this->msrp               = $item->msrp;
        $this->productName        = $item->product?->name ?? $item->title;
        $this->productCategory    = $item->category ?? $item->product?->category;
        $this->productSku         = $item->sku ?? $item->product?->sku;
        $this->productDescription = $item->product?->description;
        $this->productMSRP        = $item->msrp;
    }

    // ── Product request modal ─────────────────────────────────────────────────

    public function openRequestModal(): void
    {
        $this->requestProductName  = null;
        $this->requestProductSku   = null;
        $this->requestNotes        = null;
        $this->requestUrgency      = 'normal';
        $this->showRequestModal    = true;
    }

    public function closeRequestModal(): void
    {
        $this->showRequestModal = false;
    }

    public function submitProductRequest(): void
    {
        $this->validate([
            'requestProductName' => 'required|string|max:255',
            'requestProductSku'  => 'nullable|string|max:200',
            'requestNotes'       => 'nullable|string|max:2000',
            'requestUrgency'     => 'nullable|in:low,normal,high',
        ]);

        $user = Auth::user();

        ProductRequest::create([
            'provider_id'   => $user->reseller?->provider_id
                             ?? $user->provider?->id
                             ?? null,
            'reseller_id'   => $user->reseller?->id ?? null,
            'customer_id'   => $user->customer?->id ?? null,
            'user_id'       => $user->id,
            'product_name'  => $this->requestProductName,
            'sku'           => $this->requestProductSku,
            'notes'         => $this->requestNotes,
            'urgency'       => $this->requestUrgency ?? 'normal',
        ]);

        $this->showRequestModal   = false;
        $this->requestProductName = null;
        $this->requestProductSku  = null;
        $this->requestNotes       = null;

        $this->notify('Your product request has been submitted.');
    }

    // ── Cart helpers ──────────────────────────────────────────────────────────

    public static function getUserCart($id = null, $token = null)
    {
        $user = Auth::user();
        if (empty($token)) {
            if (empty($id)) {
                $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->first();
            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->first();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->first();
        }
        return $cart;
    }

    // ── Filter helpers ────────────────────────────────────────────────────────

    public function updatedVendor()
    {
        $this->useCachedRows();
        if (! is_array($this->vendor)) {
            return;
        }
        $this->vendor = array_filter($this->vendor, fn ($v) => $v != false);
    }

    // ── Data query ────────────────────────────────────────────────────────────

    public function getRowsQueryProperty(): Builder
    {
        $this->useCachedRows();
        $this->priceList = $this->resolveUserPriceListId();

        $query = PriceListItem::query()
            ->with('product')
            ->where('price_list_id', $this->priceList)
            ->where('available_for_purchase', true)
            ->when($this->filters['category'], fn ($q, $category) =>
                $q->where(fn ($inner) =>
                    $inner->where('category', $category)
                          ->orWhereHas('product', fn ($p) => $p->where('category', $category))
                )
            )
            ->when($this->filters['vendors'], fn ($q, $vendor) =>
                $q->where(fn ($inner) =>
                    $inner->where('vendor', $vendor)
                          ->orWhereHas('product', fn ($p) => $p->where('vendor', $vendor))
                )
            )
            ->when($this->filters['producttype'], fn ($q, $producttype) =>
                $q->where(fn ($inner) =>
                    $inner->where('product_type', $producttype)
                          ->orWhereHas('product', fn ($p) => $p->where('productType', $producttype))
                )
            )
            ->when($this->filters['plugins'], fn ($q) =>
                $q->whereHas('product', fn ($p) => $p->where('is_addon', true))
            )
            ->when($this->filters['trial'], fn ($q) =>
                $q->whereHas('product', fn ($p) => $p->where('is_trial', true))
            )
            ->when($this->filters['billing'], fn ($q, $billing) =>
                $q->where('billing_cycle', $billing)
            )
            ->when($this->filters['terms'], fn ($q, $terms) =>
                $q->where('term_duration', $terms)
            )
            ->when($this->search, fn ($q, $search) =>
                $q->where(fn ($inner) =>
                    $inner->where('title', 'like', '%' . $search . '%')
                          ->orWhere('sku', 'like', '%' . $search . '%')
                          ->orWhereHas('product', fn ($p) =>
                              $p->where('name', 'like', '%' . $search . '%')
                               ->orWhere('sku', 'like', '%' . $search . '%')
                          )
                )
            );

        return $this->applySorting($query);
    }

    public function mount(): void
    {
        $this->useCachedRows();

        $resolvedPl       = $this->resolveUserPriceList();
        $this->priceList  = $resolvedPl?->id;
        $this->resolvedPriceListName = $resolvedPl?->name;

        $plId = $this->priceList;

        $this->terms = PriceListItem::where('price_list_id', $plId)
            ->where('available_for_purchase', true)
            ->pluck('term_duration')
            ->unique()
            ->filter()
            ->values();

        $this->categories = PriceListItem::where('price_list_id', $plId)
            ->where('available_for_purchase', true)
            ->pluck('category')
            ->push(
                // Also pull from linked products for richer category list.
                ...PriceListItem::where('price_list_id', $plId)
                    ->where('available_for_purchase', true)
                    ->whereNotNull('product_id')
                    ->with('product:id,category')
                    ->get()
                    ->pluck('product.category')
                    ->filter()
                    ->toArray()
            )
            ->unique()
            ->filter()
            ->values();

        $this->vendors = PriceListItem::where('price_list_id', $plId)
            ->where('available_for_purchase', true)
            ->pluck('vendor')
            ->unique()
            ->filter()
            ->values();

        $this->productType = PriceListItem::where('price_list_id', $plId)
            ->where('available_for_purchase', true)
            ->pluck('product_type')
            ->unique()
            ->filter()
            ->values();
    }

    // ── Price-list resolution ─────────────────────────────────────────────────

    /**
     * Resolve and return the full PriceList object for the authenticated user.
     * Returns null when no active price list is configured.
     * Aborts 403 for users that are neither Reseller nor Customer.
     */
    private function resolveUserPriceList(): ?PriceList
    {
        $user  = Auth::user();
        $level = $user->userLevel->name ?? null;

        if (! in_array($level, ['Reseller', 'Customer'], true)) {
            abort(403, __('errors.access_with_resellers_credentials'));
        }

        try {
            $resolver = app(PriceListResolver::class);
            return ($level === 'Customer')
                ? $resolver->resolveForPurchaseByUser($user, $user->customer)
                : $resolver->resolveForReseller($user);
        } catch (\RuntimeException) {
            return null;
        }
    }

    /**
     * Resolve and return only the price list ID (null-safe).
     */
    private function resolveUserPriceListId(): ?int
    {
        return $this->resolveUserPriceList()?->id;
    }

    // ── Render ────────────────────────────────────────────────────────────────

    public function getRowsProperty()
    {
        $this->useCachedRows();
        return $this->cache(fn () => $this->applyPagination($this->rowsQuery));
    }

    public function render()
    {
        $this->useCachedRows();

        return view('livewire.store.store', [
            'prices'               => $this->rows,
            'vendors'              => $this->vendors,
            'category'             => $this->categories,
            'terms'                => $this->terms,
            'producttype'          => $this->productType,
            'resolvedPriceListName'=> $this->resolvedPriceListName,
        ]);
    }
}
