<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pricing\PriceRule;
use App\Models\Pricing\PriceRuleSet;
use App\Models\Pricing\PricingSafeguard;
use App\Services\Pricing\PriceContext;
use App\Services\Pricing\PricingEngine;
use App\Services\Pricing\Catalog\PricingCatalogNormalizer;
use App\Services\Pricing\Import\MicrosoftPricingImporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        return view('pricing.index');
    }

    public function rules()
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $ruleSets = PriceRuleSet::query()->where('provider_id', $providerId)->orderByDesc('priority')->get();
        $rules = PriceRule::query()
            ->whereIn('rule_set_id', $ruleSets->pluck('id'))
            ->orderByDesc('priority')
            ->orderByDesc('id')
            ->get();

        return view('pricing.rules.index', compact('ruleSets', 'rules'));
    }

    public function rulesCreate()
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $ruleSets = PriceRuleSet::query()->where('provider_id', $providerId)->orderByDesc('priority')->get();
        return view('pricing.rules.form', [
            'mode' => 'create',
            'rule' => new PriceRule(),
            'ruleSets' => $ruleSets,
        ]);
    }

    public function rulesStore(Request $request)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $data = $request->validate([
            'rule_set_id' => 'required|integer|exists:price_rule_sets,id',
            'scope_type' => 'required|string',
            'scope_id' => 'nullable|integer',
            'match_type' => 'required|string',
            'match_value' => 'nullable|string',
            'base_price' => 'required|in:cost,erp',
            'operation' => 'required|in:markup_percent,markup_fixed,discount_percent,fixed_price,tiered',
            'value' => 'required|numeric',
            'priority' => 'required|integer',
            'enabled' => 'required|boolean',
            'rounding_mode' => 'required|in:none,to_cents,to_0_05,to_1',
        ]);

        // ensure rule set belongs to provider
        abort_unless(PriceRuleSet::query()->where('id', $data['rule_set_id'])->where('provider_id', $providerId)->exists(), 403);

        PriceRule::create($data);

        return redirect()->route('pricing.rules')->with('success', 'Rule created');
    }

    public function rulesEdit(int $id)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $rule = PriceRule::findOrFail($id);
        $ruleSet = PriceRuleSet::findOrFail($rule->rule_set_id);
        abort_unless($ruleSet->provider_id === $providerId, 403);

        $ruleSets = PriceRuleSet::query()->where('provider_id', $providerId)->orderByDesc('priority')->get();

        return view('pricing.rules.form', [
            'mode' => 'edit',
            'rule' => $rule,
            'ruleSets' => $ruleSets,
        ]);
    }

    public function rulesUpdate(Request $request, int $id)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $rule = PriceRule::findOrFail($id);
        $ruleSet = PriceRuleSet::findOrFail($rule->rule_set_id);
        abort_unless($ruleSet->provider_id === $providerId, 403);

        $data = $request->validate([
            'rule_set_id' => 'required|integer|exists:price_rule_sets,id',
            'scope_type' => 'required|string',
            'scope_id' => 'nullable|integer',
            'match_type' => 'required|string',
            'match_value' => 'nullable|string',
            'base_price' => 'required|in:cost,erp',
            'operation' => 'required|in:markup_percent,markup_fixed,discount_percent,fixed_price,tiered',
            'value' => 'required|numeric',
            'priority' => 'required|integer',
            'enabled' => 'required|boolean',
            'rounding_mode' => 'required|in:none,to_cents,to_0_05,to_1',
        ]);

        abort_unless(PriceRuleSet::query()->where('id', $data['rule_set_id'])->where('provider_id', $providerId)->exists(), 403);

        $rule->update($data);

        return redirect()->route('pricing.rules')->with('success', 'Rule updated');
    }

    public function rulesDelete(int $id)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $rule = PriceRule::findOrFail($id);
        $ruleSet = PriceRuleSet::findOrFail($rule->rule_set_id);
        abort_unless($ruleSet->provider_id === $providerId, 403);

        $rule->delete();

        return redirect()->route('pricing.rules')->with('success', 'Rule deleted');
    }

    public function simulator()
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $safeguards = PricingSafeguard::firstOrCreate(['provider_id' => $providerId]);

        return view('pricing.simulator', compact('safeguards'));
    }

    public function normalize(Request $request, PricingCatalogNormalizer $normalizer)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $force = (bool) $request->boolean('force');
        $result = $normalizer->normalizeLatestPriceListForProvider((int)$providerId, null, null, $force);

        return redirect()->route('pricing.index')->with('success', "Catalog normalized: scanned {$result->scanned}, updated {$result->updated}, unmapped {$result->unmapped}");
    }

    public function importMicrosoft(Request $request, MicrosoftPricingImporter $importer)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $data = $request->validate([
            'market' => 'required|string|max:10',
            'currency' => 'required|string|max:10',
        ]);

        $res = $importer->importLatestMonthly((int)$providerId, $data['market'], $data['currency']);

        if ($res->error) {
            return redirect()->route('pricing.index')->with('danger', 'Import failed: ' . $res->error);
        }

        $norm = $res->normalization;
        return redirect()->route('pricing.index')->with('success',
            "Imported: scanned {$res->itemsScanned}, upserted {$res->itemsUpserted}, updated {$res->itemsUpdated}. Normalized: updated {$norm->updated}, unmapped {$norm->unmapped}."
        );
    }

    public function simulate(Request $request, PricingEngine $engine)
    {
        $providerId = Auth::user()->provider?->id;
        abort_unless($providerId, 403);

        $data = $request->validate([
            'market' => 'required|string',
            'currency' => 'required|string',
            'product_type' => 'required|in:license,azure,perpetual',
            'offer_id' => 'nullable|string',
            'sku_id' => 'nullable|string',
            'meter_id' => 'nullable|string',
            'product_family' => 'nullable|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|array',
            'billing_cycle' => 'nullable|string',
            'term' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'reseller_id' => 'nullable|integer',
            'customer_id' => 'nullable|integer',
        ]);

        $ctx = new PriceContext(
            providerId: $providerId,
            resellerId: $data['reseller_id'] ?? null,
            customerId: $data['customer_id'] ?? null,
            market: $data['market'],
            currency: $data['currency'],
            productType: $data['product_type'],
            offerId: $data['offer_id'] ?? null,
            skuId: $data['sku_id'] ?? null,
            meterId: $data['meter_id'] ?? null,
            productFamily: $data['product_family'] ?? null,
            category: $data['category'] ?? null,
            tags: $data['tags'] ?? [],
            billingCycle: $data['billing_cycle'] ?? null,
            term: $data['term'] ?? null,
            quantity: $data['quantity'],
        );

        $result = $engine->explainLine($ctx);

        return response()->json($result->toArray());
    }
}
