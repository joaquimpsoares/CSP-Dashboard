<?php

namespace App\Repositories\Pricelist;

use App\Pricelist;


class EloquentPricelist implements PricelistRepository
{

    public function lists($column = 'name', $key = 'id')
    {
        return Pricelist::orderBy('name')->pluck($column, $key);
    }

    public function all()
    {
        $this->pricelist->all();
    }


}
