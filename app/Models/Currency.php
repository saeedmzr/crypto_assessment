<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Currency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rates(): HasManyThrough
    {
        return $this->hasManyThrough(Rate::class, 'currencies', 'id', 'first_currency_id')->orWhere('second_currency_id', $this->id);
    }
}
