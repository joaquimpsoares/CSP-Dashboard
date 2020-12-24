<?php

namespace App\Imports;

use App\Price;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class PricesImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(Array $row)
    {

        Price::updateOrCreate([
            'name'          => $row['name'],
        ],
        [
            'instance'      => $row['instance'],
            'sku'           => Product::where('sku', $row['sku'])->where('instance_id', $row['instance'])->firstOrFail()->id,
            'price'         => $row['price'],
            'msrp'          => $row['msrp'],
            'currency'      => $row['currency'],
            'product_vendor'=> $row['vendor'],
            'priceListId'   => $row['pricelist'],
        ]);
        // return new Price([
        //     'name'          => $row['name'],
        //     'sku'           => $row['sku'],
        //     'price'         => $row['price'],
        //     'msrp'          => $row['msrp'],
        //     'currency'      => $row['currency'],
        //     'product_vendor'=> $row['vendor'],
        //     'priceListId'   => $row['pricelist'],

        // ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
