<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_rule_sets', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('provider_id');
            $table->string('name');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->string('applies_to', 16)->default('all'); // licenses|azure|all

            $table->timestamps();

            $table->index(['provider_id', 'is_active', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_rule_sets');
    }
};
