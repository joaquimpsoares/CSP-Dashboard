<?php

namespace App\Console\Commands;

use App\Provider;
use Illuminate\Console\Command;
use App\Models\BullethqInvoices;
use App\Models\BullethqPayments;
use Illuminate\Support\Facades\Http;
use AddBullethpuserIdToProvidersTable;

class SyncBullet extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:SyncBullet';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $payments = Http::withBasicAuth('joaquim.soares@tagydes.com', '25a142a35cccedbb8465cf148790eefe')
        ->get('https://accounts-app.bullethq.com/api/v1/clientPayments')->collect();

        $invoices = Http::withBasicAuth('joaquim.soares@tagydes.com', '25a142a35cccedbb8465cf148790eefe')
        ->get('https://accounts-app.bullethq.com/api/v1/invoices')->collect();

        // dd($invoices->first());

        // $provider =Provider::eachById(function (Provider $provider) {
        //     if(!empty($provider->bullethq_id)){
        //         $provider = BullethqInvoices::where('clientId', $provider->bullethq_id)->get();
        //         dd($provider);
        //     }
        // });

        // dd($provider);

        foreach($invoices as $invoice){
            $tt = BullethqInvoices::updateorcreate([
                "bullethq_id"   => $invoice['id']
            ],[
                "outstandingAmount" => $invoice['outstandingAmount'],
                "currency"          => $invoice['currency'],
                "dueDate"           => $invoice['dueDate'],
                "issueDate"         => $invoice['issueDate'],
                "clientName"        => $invoice['clientName'],
                "clientId"          => $invoice['clientId'],
                "invoiceLines"      => $invoice['invoiceLines'],

            ]);
            // dd($tt);


            foreach($payments as $payment){
                BullethqPayments::updateorcreate([
                    "bullethq_id"   => $payment['id']
                ],[
                    "exchangeRate"  => $payment['exchangeRate'],
                    "amount"        => $payment['amount'],
                    "dateReceived"  => $payment['dateReceived'],
                    "clientId"      => $payment['clientId'],
                    "invoiceIds"    => $payment['invoiceIds'],

                ]);
            }



        }
    }
}
