<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsftInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MsftInvoices', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id')->nullable();
            $table->string('instance_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->date('invoiceDate')->nullable();
            $table->date('billingPeriodStartDate')->nullable();
            $table->date('billingPeriodEndDate')->nullable();
            $table->string('totalCharges')->nullable();
            $table->string('paidAmount')->nullable();
            $table->string('currencyCode')->nullable();
            $table->string('currencySymbol')->nullable();
            $table->string('pdfDownloadLink')->nullable();
            $table->json('invoiceDetails')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MsftInvoices');
    }
}
