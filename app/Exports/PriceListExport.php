<?php

namespace App\Exports;


use App\PriceList;
use Maatwebsite\Excel\Concerns\FromCollection;

class PriceListExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PriceList::all();
    }
}
