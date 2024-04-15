<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\Rate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class CurrencyRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(Currency $model)
    {
        $this->model = $model;
    }
}
