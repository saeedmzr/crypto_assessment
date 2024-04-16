<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getOrderByTrackingCode(string $trackingCode)
    {
        return $this->model->where('tracking_code', $trackingCode)->first();
    }

    public function generateTrackingCode(int $orderId): void
    {
        $randomString = Str::random(10);
        $order = $this->getOrderByTrackingCode($randomString);
        while (!is_null($order)) {
            $randomString = Str::random(10);
            $order = $this->getOrderByTrackingCode($randomString);

        }
        $this->findById($orderId)->update(['tracking_code' => $randomString]);
    }
}
