<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveFromProductsSkuToId extends Migration
{
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
        });
    }
}
