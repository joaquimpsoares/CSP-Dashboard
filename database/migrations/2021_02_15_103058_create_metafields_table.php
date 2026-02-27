<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetafieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metafields', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('key');
            $table->text('value');

            $table->unsignedBigInteger('metafieldable_id');
            $table->string('metafieldable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metafields');
    }
}
