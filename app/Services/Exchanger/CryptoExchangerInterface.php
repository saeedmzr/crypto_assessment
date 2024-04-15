<?php

namespace App\Services\Exchanger;

use Illuminate\Http\JsonResponse;

interface CryptoExchangerInterface
{
    public function getRate(string $firstSymbol, string $secondSymbol): float|JsonResponse;
}
