<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('customers', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('company_name', 100);
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('nif', 15);
            $table->string('postal_code', 15)->nullable();
            $table->double('markup', 6,2)->nullable();
            $table->unsignedSmallInteger('status_id');
            $table->unsignedBigInteger('price_list_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('price_list_id')->references('id')->on('price_lists');


        });

        DB::statement("ALTER TABLE customers AUTO_INCREMENT = 310000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
