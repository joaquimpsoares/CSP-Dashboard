<?php

use App\Instance;
use App\PriceList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePricelistProviderRelationship extends Migration
{
    public function up(): void
    {
        Schema::table('price_lists', function(Blueprint $table){
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('reseller_id')->nullable();
        });

        PriceList::whereNotNull('instance_id')->eachById(function(PriceList $priceList){
            $priceList->update(['provider_id' => Instance::findOrFail($priceList->instance_id)->provider->id]);
        });
    }
}
