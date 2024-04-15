<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $btc = Currency::query()->create(
            ["title" => "Bitcoin", "symbol" => "BTC"]
        );
        $tether = Currency::query()->create(
            ["title" => "Tether", "symbol" => "USDT"]
        );
        $irr = Currency::query()->create(
            ["title" => "Rial", "symbol" => "IRR"]
        );

        Rate::create([
            'origin_currency_id' => $btc->id,
            'destination_currency_id' => $tether->id,
            'ratio' => 1,
            'internal' => false,
        ]);
        Rate::create([
            'origin_currency_id' => $btc->id,
            'destination_currency_id' => $irr->id,
            'ratio' => 1,
            'internal' => true,
        ]);
        Rate::create([
            'origin_currency_id' => $tether->id,
            'destination_currency_id' => $irr->id,
            'ratio' => 1,
            'internal' => true,

        ]);


    }
}