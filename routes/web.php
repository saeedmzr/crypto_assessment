<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    $obj = new \App\Services\CryptoService(new \App\Services\Exchanger\FCSApi());
    $a = $obj->getRate("BTC", "USD");
    return response()->json($a);
});
