<?php

namespace App\Services;

use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RateRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository    $orderRepository,
        private RateRepository     $rateRepository,
        private CurrencyRepository $currencyRepository,
    )
    {

    }

    public function createOrder(array $data): \Illuminate\Database\Eloquent\Model|false
    {

//        try {
        DB::beginTransaction();
        $firstCurrency = $this->currencyRepository->findBySymbol($data['first_symbol']);
        $secondCurrency = $this->currencyRepository->findBySymbol($data['second_symbol']);
        $email = $data['email'];
        $amount = $data['amount'];

        $rate = $this->rateRepository->getRateRecord($firstCurrency->id, $secondCurrency->id);
        if ($rate->firstCurrency->id != $firstCurrency->id) $rate = 1 / $rate;
        $amountReceived = $amount / $rate->ratio;
        $payload = [
            "rate_id" => $rate->id,
            "amount_received" => $amountReceived,
            "amount_paid" => $amount,
            "rate_state_value" => $rate->ratio,
            "email_address" => $email,
        ];
        $order = $this->orderRepository->create($payload);
        $this->orderRepository->generateTrackingCode($order->id);
        DB::commit();
        return $order->fresh();
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            return false;
//        }

    }
}
