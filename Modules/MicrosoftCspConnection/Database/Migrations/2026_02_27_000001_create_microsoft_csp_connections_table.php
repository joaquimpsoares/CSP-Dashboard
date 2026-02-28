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
        Schema::create('microsoft_csp_connections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('provider_id')->index();
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');

            // The Azure AD tenant ID of this CSP partner account
            $table->string('tenant_id')->index();

            // Token acquisition mode:
            //   'app_only' — client_credentials (app ID + secret)
            //   'sam'      — Secure Application Model (refresh_token)
            $table->string('token_mode')->default('app_only');

            // APP_ONLY credentials (also used as the app registration for SAM)
            $table->string('client_id')->nullable();
            $table->text('client_secret')->nullable();   // encrypted at rest

            // SAM refresh token (encrypted at rest)
            $table->text('refresh_token')->nullable();

            // Microsoft Partner Network ID (MPN / partner_id)
            $table->string('partner_id')->nullable();

            // Per-provider API URL override (e.g. sandbox endpoint)
            $table->string('api_url')->nullable();

            // Consent tracking
            $table->timestamp('consented_at')->nullable();

            // MFA compliance (tracked per SAM API response headers)
            $table->boolean('mfa_compliant')->nullable();
            $table->timestamp('mfa_checked_at')->nullable();

            $table->timestamps();

            // A provider can have one connection per tenant
            $table->unique(['provider_id', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microsoft_csp_connections');
    }
};
