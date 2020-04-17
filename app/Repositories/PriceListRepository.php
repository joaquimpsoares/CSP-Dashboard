<?php

namespace App\Repositories;

use App\PriceList;


class PriceListRepository implements PriceListRepositoryInterface
{
	
	public function all()
	{
		$priceLists = PriceList::orderBy('name')->get()->map->format();
		return $priceLists;
	}
}