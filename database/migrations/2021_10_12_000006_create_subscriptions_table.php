<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('subscriptions', function (Blueprint $table) {
            
            $table->id('id');
            $table->string('name');
            $table->string('subscription_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('product_id');
            $table->string('order_id');
            $table->string('amount');
            $table->string('instance_id');
            $table->string('msrpid')->nullable();
            $table->date('expiration_data')->nullable();
            $table->string('billing_period');
            $table->string('currency');
            $table->string('tenant_name');
            $table->unsignedSmallInteger('status_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('status_id')->references('id')->on('statuses');

        });


        DB::statement("ALTER TABLE subscriptions AUTO_INCREMENT = 610000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
