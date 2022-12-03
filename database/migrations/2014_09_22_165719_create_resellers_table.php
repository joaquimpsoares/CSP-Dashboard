<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('resellers', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('company_name', 100);
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('nif', 15);
            $table->string('postal_code', 15)->nullable();
            // Every not null main_office means a branch_office
            $table->unsignedBigInteger('main_office')->nullable();
            $table->unsignedBigInteger('price_list_id')->nullable();
            $table->decimal('markup', 8, 2)->nullable();
            $table->unsignedSmallInteger('status_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('main_office')->references('id')->on('resellers');
            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->foreign('status_id')->references('id')->on('statuses');

        });

        DB::statement("ALTER TABLE resellers AUTO_INCREMENT = 210000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('resellers');
    }
}
