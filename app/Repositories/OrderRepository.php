<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }
}
