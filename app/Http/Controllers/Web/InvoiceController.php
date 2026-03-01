<?php

namespace App\Http\Controllers\Web;

use App\Invoice;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $invoices = Invoice::query()->latest()->paginate(20);

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeAccess();

        $invoice->load('lines');

        return view('invoices.show', compact('invoice'));
    }

    private function authorizeAccess(): void
    {
        $u = Auth::user();
        abort_unless($u && ($u->hasRole('Super Admin') || $u->hasRole('Admin') || $u->hasRole('Provider')), 403);
    }
}
