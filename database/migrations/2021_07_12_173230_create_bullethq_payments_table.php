<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBullethqPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bullethq_payments', function (Blueprint $table) {
            $table->id();
            $table->string('bullethq_id')->nullable();
            $table->string('exchangeRate')->nullable();
            $table->string('amount')->nullable();
            $table->date('dateReceived')->nullable();
            $table->string('clientId')->nullable();
            $table->text('invoiceIds')->nullable();
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
        Schema::dropIfExists('bullethq_payments');
    }
}
