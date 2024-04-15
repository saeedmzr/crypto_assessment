<?php

namespace App\Services;

use App\Services\Exchanger\CryptoExchangerInterface;
use Illuminate\Http\JsonResponse;

class CryptoService
{
    private $exchangerInstance;

    public function __construct(CryptoExchangerInterface $exchangerInstance)
    {
        $this->exchangerInstance = $exchangerInstance;
    }

    public function getRate($firstSymbol, $secondSymbol): float|JsonResponse
    {
        $rate = $this->exchangerInstance->getRate($firstSymbol, $secondSymbol);
        return $rate;
    }
    public function updateRate()
    {

    }
}
