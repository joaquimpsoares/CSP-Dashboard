<?php

namespace App\Console\Commands;

use Exception;
use App\Instance;
use App\Models\MsftInvoices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Tagydes\MicrosoftConnection\Facades\MSFTInvoice as MicrosoftInvoice;


class SyncMSFTInvoices extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:SyncMSFTInvoices';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        try{
            Instance::eachById(function (Instance $instance) {
                $invoices = MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->all();
                $invoices->each(function ($invoices) use ($instance) {
                    $product = MsftInvoices::updateOrCreate([
                        'instance_id'               => $instance->id,
                        'invoice_id'                => $invoices->invoice_id,
                        'provider_id'               => $instance->provider_id,
                    ], [
                        'invoiceDate'               => $invoices->invoiceDate,
                        'billingPeriodStartDate'    => $invoices->billingPeriodStartDate,
                        'billingPeriodEndDate'      => $invoices->billingPeriodEndDate,
                        'totalCharges'              => $invoices->totalCharges,
                        'paidAmount'                => $invoices->paidAmount,
                        'currencyCode'              => $invoices->currencyCode,
                        'currencySymbol'            => $invoices->currencySymbol,
                        'pdfDownloadLink'           => $invoices->pdfDownloadLink,
                        'invoiceDetails'            => $invoices->invoiceLineItemType,
                    ]);


                });
            });

        }
        catch (Exception $e) {
            echo ('Error importing products: ' . $e->getMessage());

        }
        Mail::raw("Just finished msft invoices Syncronization", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Monthly import MSFT Invoices');
        });
        $this->info('Successfully sent daily quote to everyone.');
    }
}
