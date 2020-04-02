<?php

namespace App\Repositories\Pricelist;



interface PricelistRepository
{


    public function all();

    public function lists($column = 'name', $key = 'id');



}
