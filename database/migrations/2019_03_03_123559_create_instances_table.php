<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('type');
            $table->unsignedBigInteger('provider_id');
            
            $table->string('external_id')->nullable();
            $table->string('external_type')->nullable();
            $table->string('external_url')->nullable();
            
            $table->text('external_token')->nullable();
            $table->timestamp('external_token_updated_at')->nullable();

            $table->foreign('provider_id')->references('id')->on('providers');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instances');
    }
}
