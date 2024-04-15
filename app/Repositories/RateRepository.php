<?php

namespace App\Repositories;

use App\Models\Rate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RateRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(Rate $model)
    {
        $this->model = $model;
    }

    public function getRateRecord($firstSymbolId, $secondSymbolId)
    {
        return $this->model::where(function ($query) use ($firstSymbolId, $secondSymbolId) {
            $query->where('origin_currency_id', $firstSymbolId)
                ->where('destination_currency_id', $secondSymbolId);
        })
            ->orWhere(function ($query) use ($firstSymbolId, $secondSymbolId) {
                $query->where('origin_currency_id', $secondSymbolId)
                    ->where('destination_currency_id', $firstSymbolId);
            })
            ->first();
    }

    public function updateRateRecord($firstSymbolId, $secondSymbolId, $rateAmount)
    {
        $rate = $this->getRateRecord($firstSymbolId, $secondSymbolId);
        if (!$rate) $this->model->create(
            ['origin_currency_id' => $firstSymbolId,
                'destination_currency_id' => $secondSymbolId,
            ]);

        $rate->update(['ratio' => $rateAmount]);
        return $rate;
    }
}
