<?php


use App\AzureResource;
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class exportAzure implements FromCollection, WithHeadings

{
    protected $azureresources;

    public function headings(): array
    {
        return [
            '#',
            'User',
            'Date',
        ];
    }

    // public function __construct(array $azureresources)
    // {
    //     $this->azureresources = $azureresources;
    // }

    // public function map($azureresources): array
    // {

    //     dd($azureresources);
    //     // This example will return 3 rows.
    //     // First row will have 2 column, the next 2 will have 1 column
    //     return [
    //         [
    //             $azureresources->usageStartTime,

    //         ],
    //         // [
    //         //     $azureresources->lines->first()->description,
    //         // ],
    //         // [
    //         //     $azureresources->lines->last()->description,
    //         // ]
    //     ];
    // }

    public function collection(): array
    {
        return $this->azureresources;
    }
}
