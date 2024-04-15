<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/orders", [\App\Http\Controllers\Api\OrderController::class, 'store']);
Route::get("/orders", [\App\Http\Controllers\Api\OrderController::class, 'show']);
