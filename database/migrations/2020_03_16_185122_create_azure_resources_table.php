<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAzureResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_resources', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('azure_id');

            $table->string('name');
            $table->string('unit');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->string('currency');

            $table->decimal('cost', 8, 2);
            $table->double('used');
            $table->unsignedInteger('margin')->nullable();

            $table->timestamp('azure_updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_resources');
    }
}
