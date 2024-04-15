<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rate extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function originCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'origin_currency_id');
    }

    public function destinationCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'destination_currency_id');
    }
}
