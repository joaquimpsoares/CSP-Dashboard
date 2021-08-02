<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBullethqInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bullethq_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id')->nullable();
            $table->string('outstandingAmount')->nullable();
            $table->string('bullethq_id')->nullable();
            $table->string('currency')->nullable();
            $table->date('dueDate')->nullable();
            $table->date('issueDate')->nullable();
            $table->string('clientName')->nullable();
            $table->string('clientId')->nullable();
            $table->text('invoiceLines')->nullable();
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
        Schema::dropIfExists('bullethq_invoices');
    }
}
