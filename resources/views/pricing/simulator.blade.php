<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Pricing Simulator</h2>
            <p class="mt-1 text-sm text-slate-600">Compute a quote line and inspect “why this price”.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Product type</label>
                            <select id="product_type" class="mt-1 w-full rounded-lg border-slate-300">
                                <option value="license">license</option>
                                <option value="azure">azure</option>
                                <option value="perpetual">perpetual</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Market</label>
                            <input id="market" class="mt-1 w-full rounded-lg border-slate-300" value="ES" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Currency</label>
                            <input id="currency" class="mt-1 w-full rounded-lg border-slate-300" value="EUR" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">SKU ID</label>
                            <input id="sku_id" class="mt-1 w-full rounded-lg border-slate-300" placeholder="SKU" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Offer ID</label>
                            <input id="offer_id" class="mt-1 w-full rounded-lg border-slate-300" placeholder="Offer" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Meter ID (Azure)</label>
                            <input id="meter_id" class="mt-1 w-full rounded-lg border-slate-300" placeholder="Meter" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Product family (optional)</label>
                            <input id="product_family" class="mt-1 w-full rounded-lg border-slate-300" placeholder="e.g. Microsoft 365" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Category (optional)</label>
                            <input id="category" class="mt-1 w-full rounded-lg border-slate-300" placeholder="e.g. azure|license" />
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Quantity</label>
                            <input id="quantity" type="number" class="mt-1 w-full rounded-lg border-slate-300" value="1" min="1" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-slate-700">Tags (one per line: key=value)</label>
                            <textarea id="tags" class="mt-1 w-full rounded-lg border-slate-300" rows="4" placeholder="env=prod\nregion=eu"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button id="btnSim" class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white">Simulate</button>
                        <span id="status" class="text-sm text-slate-600"></span>
                    </div>

                    <div id="summary" class="mt-6 hidden rounded-xl border border-slate-200 bg-white p-4">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="text-xs text-slate-500">Sell unit</div>
                                <div id="sell_unit" class="text-lg font-semibold text-slate-900"></div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">Sell total</div>
                                <div id="sell_total" class="text-lg font-semibold text-slate-900"></div>
                            </div>
                            <div class="md:text-right">
                                <div class="text-xs text-slate-500">Winning rule</div>
                                <div id="win_rule" class="text-sm font-semibold text-slate-900"></div>
                                <div id="win_reason" class="text-xs text-slate-600"></div>
                            </div>
                        </div>

                        <details class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Why this price?</summary>
                            <pre id="out" class="mt-3 whitespace-pre-wrap text-xs text-slate-800"></pre>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function parseTags(text) {
            const tags = {};
            (text || '').split(/\r?\n/).forEach(line => {
                const t = line.trim();
                if (!t) return;
                const parts = t.split('=', 2);
                if (parts.length !== 2) return;
                const k = parts[0].trim();
                const v = parts[1].trim();
                if (!k || !v) return;
                tags[k] = v;
            });
            return tags;
        }

        async function simulate() {
            const payload = {
                market: document.getElementById('market').value,
                currency: document.getElementById('currency').value,
                product_type: document.getElementById('product_type').value,
                sku_id: document.getElementById('sku_id').value || null,
                offer_id: document.getElementById('offer_id').value || null,
                meter_id: document.getElementById('meter_id').value || null,
                product_family: document.getElementById('product_family').value || null,
                category: document.getElementById('category').value || null,
                tags: parseTags(document.getElementById('tags').value),
                billing_cycle: null,
                term: null,
                quantity: parseInt(document.getElementById('quantity').value || '1', 10),
                reseller_id: null,
                customer_id: null,
            };

            document.getElementById('status').textContent = 'Computing...';
            const res = await fetch("{{ route('pricing.simulate') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(payload),
            });
            const data = await res.json();
            document.getElementById('status').textContent = data.ok ? 'OK' : ('ERROR: ' + data.reason);

            if (data.ok) {
                document.getElementById('summary').classList.remove('hidden');
                document.getElementById('sell_unit').textContent = data.outputs.sell_unit;
                document.getElementById('sell_total').textContent = data.outputs.sell_total;
                document.getElementById('win_rule').textContent = data.winning_rule ? (data.winning_rule.scope_type + ' #' + (data.winning_rule.scope_id ?? 'default') + ' · ' + data.winning_rule.match_type) : 'none';
                document.getElementById('win_reason').textContent = data.selection_reason || '';
                document.getElementById('out').textContent = JSON.stringify(data, null, 2);
            } else {
                document.getElementById('summary').classList.remove('hidden');
                document.getElementById('sell_unit').textContent = '';
                document.getElementById('sell_total').textContent = '';
                document.getElementById('win_rule').textContent = 'n/a';
                document.getElementById('win_reason').textContent = data.reason;
                document.getElementById('out').textContent = JSON.stringify(data, null, 2);
            }
        }
        document.getElementById('btnSim').addEventListener('click', simulate);
    </script>
</x-app-layout>
