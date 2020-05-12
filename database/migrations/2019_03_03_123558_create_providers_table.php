<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        

        Schema::create('providers', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('company_name', 100);
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->unsignedInteger('country_id');
            $table->string('state')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('nif', 15);
            $table->string('postal_code', 15)->nullable();
            // Every not null main_office means a branch_office
            $table->integer('main_office')->nullable();
            $table->unsignedSmallInteger('status_id')->index();
            $table->unsignedBigInteger('price_list_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('price_list_id')->references('id')->on('price_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
