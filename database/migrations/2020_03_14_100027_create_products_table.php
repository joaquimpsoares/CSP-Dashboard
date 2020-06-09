<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('vendor')->default('microsoft');
            $table->unsignedBigInteger('instance_id');
            $table->string('sku')->nullable(false);

            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('uri')->nullable();
            $table->integer('minimum_quantity')->nullable();
            $table->integer('maximum_quantity')->nullable();
            $table->integer('limit')->nullable();

            $table->text('term')->nullable();
            $table->boolean('is_available_for_purchase')->nullable();

            $table->string('locale')->nullable();
            $table->string('country')->nullable();

            $table->boolean('has_addons')->nullable();
            $table->boolean('is_trial')->nullable();
            $table->boolean('is_autorenewable')->nullable();

            $table->string('billing')->nullable();
            $table->string('acquisition_type')->nullable();

            $table->string('category')->nullable();
            $table->string('upgrade_target_offers')->nullable();
            
            $table->text('addons')->nullable();
            $table->text('supported_billing_cycles')->nullable();
            $table->text('conversion_target_offers')->nullable();
            $table->text('resellee_qualifications')->nullable();
            $table->text('reseller_qualifications')->nullable();
            $table->timestamps();

            $table->index(['sku', 'instance_id']);

            $table->foreign('instance_id')->references('id')->on('instances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
