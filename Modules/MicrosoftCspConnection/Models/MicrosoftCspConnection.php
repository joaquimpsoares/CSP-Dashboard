<?php

namespace Modules\MicrosoftCspConnection\Models;

use App\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MicrosoftCspConnection extends Model
{
    protected $table = 'microsoft_csp_connections';

    protected $fillable = [
        'provider_id',
        'tenant_id',
        'token_mode',
        'client_id',
        'client_secret',
        'refresh_token',
        'partner_id',
        'api_url',
        'consented_at',
        'mfa_compliant',
        'mfa_checked_at',
    ];

    /**
     * Attribute casts.
     * client_secret and refresh_token are encrypted using Laravel's built-in
     * "encrypted" cast (requires APP_KEY to be set).
     */
    protected $casts = [
        'client_secret'  => 'encrypted',
        'refresh_token'  => 'encrypted',
        'consented_at'   => 'datetime',
        'mfa_checked_at' => 'datetime',
        'mfa_compliant'  => 'boolean',
    ];

    /**
     * Fields hidden from serialisation (never expose secrets in JSON responses).
     */
    protected $hidden = [
        'client_secret',
        'refresh_token',
    ];

    /**
     * The provider (CSP partner) that owns this connection.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Whether this connection has the minimum credentials for APP_ONLY mode.
     */
    public function hasAppCredentials(): bool
    {
        return ! empty($this->tenant_id)
            && ! empty($this->client_id)
            && ! empty($this->client_secret);
    }

    /**
     * Whether this connection has a refresh token for SAM mode.
     */
    public function hasSamToken(): bool
    {
        return ! empty($this->tenant_id)
            && ! empty($this->client_id)
            && ! empty($this->client_secret)
            && ! empty($this->refresh_token);
    }

    /**
     * Whether the connection has valid credentials for its declared token_mode.
     */
    public function isReady(): bool
    {
        return $this->token_mode === 'sam'
            ? $this->hasSamToken()
            : $this->hasAppCredentials();
    }
}
