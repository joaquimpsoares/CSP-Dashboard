<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp_code', 60)->nullable()->after('confirmation_token');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $table->timestamp('terms_accepted_at')->nullable()->after('otp_expires_at');
            $table->unsignedTinyInteger('onboarding_step')->default(0)->after('terms_accepted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_expires_at', 'terms_accepted_at', 'onboarding_step']);
        });
    }
};
