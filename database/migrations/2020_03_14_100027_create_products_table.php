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

            $table->string('vendor')->nullable();
            $table->unsignedBigInteger('instance_id')->nullable();
            $table->string('sku')->nullable(false);

            $table->string('name');
            $table->string('description');
            $table->string('uri');

            $table->integer('minimum_quantity');
            $table->integer('maximum_quantity');
            $table->integer('limit');

            $table->text('term');
            $table->boolean('is_available_for_purchase')->nullable();

            $table->string('locale');
            $table->string('country');

            $table->boolean('has_addons');
            $table->boolean('is_trial');
            $table->boolean('is_autorenewable');

            $table->string('billing');
            $table->string('acquisition_type');

            $table->text('addons');
            $table->string('category');
            $table->string('upgrade_target_offers');
            $table->text('supported_billing_cycles');
            $table->text('conversion_target_offers');
            $table->text('reseller_qualifications');

            $table->timestamps();

            $table->unique(['sku', 'instance_id']);
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
