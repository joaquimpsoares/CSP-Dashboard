<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryrulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('countryrules', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->char('iso2Code', 2)();
            $table->char('defaultCulture')->nullable();
            $table->boolean('isStateRequired');
            $table->string('supportedStatesList')->nullable();
            $table->string('supportedLanguagesList')->nullable();
            $table->string('supportedCulturesList');
            $table->boolean('isPostalCodeRequired');
            $table->string('postalCodeRegex');
            $table->boolean('isCityRequired');
            $table->boolean('isVatIdSupported');
            $table->string('taxIdFormat')->nullable();
            $table->string('vatIdRegex')->nullable();
            $table->boolean('isTaxIdSupported');
            $table->boolean('isTaxIdOptional');
            $table->string('countryCallingCodesList');
            
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('countryCallingCodesList')
            //         ->references('calling_code')->on('countries')->onUpdate('cascade')
            //         ->onDelete('cascade');
            
        });

        DB::statement("ALTER TABLE countryrules AUTO_INCREMENT = 910000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countryrules');
    }
}
