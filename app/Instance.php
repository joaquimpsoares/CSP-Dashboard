<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Expirable;

class Instance extends Model
{

    use Expirable;

    protected $dates = [
        'created_at',
        'updated_at',
        'external_token_updated_at',
        'expires_at'
    ];

    public static function defaultExpiresAt()
    {
        return Carbon::now()->addMonths(3);
    }

    /**
     * Column used for expiration checks (used by App\Scopes\ExpirationScope).
     */
    public static function getExpirationAttribute(): string
    {
        return 'expires_at';
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function invoices(){
        return $this->hasMany(Models\MsftInvoices::class);
    }

    public function isExpired(){
        return !is_null($this->{self::getExpirationAttribute()}) && $this->{self::getExpirationAttribute()} <= Carbon::now();
    }
}
