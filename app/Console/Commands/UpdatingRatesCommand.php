<?php

namespace App\Console\Commands;

use App\Models\Rate;
use App\Repositories\CurrencyRepository;
use App\Repositories\RateRepository;
use App\Services\CryptoService;
use App\Services\Exchanger\FCSApi;
use Illuminate\Console\Command;

class UpdatingRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:updating-rates-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rateRepository = new RateRepository(new Rate());
        $rates = $rateRepository->all();
        $cryptoService = new CryptoService(new FCSApi());
        foreach ($rates as $rate) {
            if (!$rate->internal) {
                $firstSymbol = $rate->firstCurrency->symbol;
                $secondSymbol = $rate->secondCurrency->symbol;
                $ratio = $cryptoService->getRate($firstSymbol, $secondSymbol);
                $rateRepository->updateRateRecord($rate->firstCurrency->id, $rate->secondCurrency->id, $ratio);
            }
        }

    }
}
