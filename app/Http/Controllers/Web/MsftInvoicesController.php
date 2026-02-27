<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Product;
use App\Instance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MsftInvoices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tagydes\MicrosoftConnection\Facades\MSFTInvoice as MicrosoftInvoice;

class MsftInvoicesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

        $invoices = MsftInvoices::paginate(10);

        $driver = DB::getDriverName();

        $monthExpr = $driver === 'pgsql'
            ? "TO_CHAR(\"invoiceDate\", 'Mon')"
            : "MONTHNAME(invoiceDate)";

        $sales = MsftInvoices::select(
            DB::raw($monthExpr . " as date"),
            DB::raw('totalCharges as total')
        )
        ->whereYear('invoiceDate', Carbon::today()->year)
        ->groupBy(DB::raw($monthExpr))
        ->orderBy('invoiceDate', 'asc')
        ->get();

        foreach($sales as $row) {
            $invoicelabel['label'][] = json_encode($row->date);
            $invoicedata['data'][] = (int) $row->total;
        }

        $invoicelabel = json_encode($invoicelabel['label']);
        $invoicedata  = json_encode($invoicedata['data']);

        return view('msft/index', compact('invoices','invoicelabel','invoicedata'));

    }

    public function downloadInvoice($invoice)
    {
        $invoice = MsftInvoices::find($invoice);
        $instance = Instance::find($invoice->instance_id);

        return MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->downloadInvoice($invoice->pdfDownloadLink);
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\MsftInvoices  $MsftInvoices
    * @return \Illuminate\Http\Response
    */
    public function show(MsftInvoices $MsftInvoices)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\MsftInvoices  $MsftInvoices
    * @return \Illuminate\Http\Response
    */
    public function edit(MsftInvoices $MsftInvoices)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\MsftInvoices  $MsftInvoices
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, MsftInvoices $MsftInvoices)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\MsftInvoices  $MsftInvoices
    * @return \Illuminate\Http\Response
    */
    public function destroy(MsftInvoices $MsftInvoices)
    {
        //
    }
}
