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

    public function getRateRecord($symbolId, $sourceSymbolId)
    {
        return $this->model::where(function ($query) use ($symbolId, $sourceSymbolId) {
            $query->where('currency_id', $symbolId)
                ->where('source_currency_id', $sourceSymbolId);
        })
            ->orWhere(function ($query) use ($symbolId, $sourceSymbolId) {
                $query->where('currency_id', $symbolId)
                    ->where('source_currency_id', $sourceSymbolId);
            })
            ->first();
    }

    public function updateRateRecord($firstSymbolId, $secondSymbolId, $rateAmount)
    {
        $rate = $this->getRateRecord($firstSymbolId, $secondSymbolId);
        if (!$rate) $this->model->create(
            ['currency_id' => $firstSymbolId,
                'source_currency_id' => $secondSymbolId,
            ]);
        if ($rate->currency_id != $firstSymbolId) $rateAmount = 1 / $rateAmount;
        $rate->update(['price' => floatval($rateAmount)]);
        return $rate;
    }

    public function updateRatesBasedOnOtherRates($minutes = 10): void
    {
        $rates = $this->model->query()
            ->where("updated_at", "<", now()->subMinutes($minutes))
            ->get();
        foreach ($rates as $rate) {
            $currency = $rate->currency;
            $sourceCurrency = $rate->sourceCurrency;
            $sourceRatesCurrencies = $this->availableCurrenciesThatHasRates($sourceCurrency);
            $targetRatesCurrencies = $this->availableCurrenciesThatHasRates($currency);
            $commonCurrencies = array_intersect($sourceRatesCurrencies, $targetRatesCurrencies);
            $commonCurrencyId = reset($commonCurrencies);
            $firstPrice = $this->getPriceForTwoCurrencies($currency->id, $commonCurrencyId);
            $secondPrice = $this->getPriceForTwoCurrencies($commonCurrencyId, $sourceCurrency->id);
            $finalRate = $firstPrice * $secondPrice;
            if ($finalRate != 0)
                $rate->update(['price' => $finalRate]);
        }
    }

    public function availableCurrenciesThatHasRates($currency, $minutes = 10): array
    {
        $currencyId = $currency->id;
        $rates = $currency->allRates
            ->where("updated_at", ">", now()->subMinutes($minutes));
        $sources = $rates->pluck('source_currency_id')->toArray();
        $targets = $rates->pluck('currency_id')->toArray();
        $outputs = array_unique(array_merge($targets, $sources));
        $filteredArray = array_filter($outputs, function ($item) use ($currencyId) {
            return $item !== $currencyId;
        });
        return $filteredArray;
    }

    public function getPriceForTwoCurrencies($currencyId, $sourceCurrencyId)
    {
        $rate = $this->model->query()
            ->where("currency_id", $currencyId)
            ->where("source_currency_id", $sourceCurrencyId)
            ->first();
        if ($rate)
            return $rate->price;
        $rate = $this->model->query()
            ->where("source_currency_id", $currencyId)
            ->where("currency_id", $sourceCurrencyId)
            ->first();
        if ($rate) return 1 / $rate->price;
        return null;
    }

}
