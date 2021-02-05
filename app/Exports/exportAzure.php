<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\AzureUsageReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class exportAzure implements FromQuery, WithHeadings

{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'subscription_id',
            'Resource Group',
            'resource_location',
            'resource_id',
            'resource_name',
            'resource_category',
            'resource_subcategory',
            'resource_region',
            'quantity',
            'unit',
            'ext_order_id',
            'usageStartTime',
            'usageEndTime',
            'cost',
            'created_at',
            'updated_at',
            'resourceType',
            'usageResourceKind',
            'dataCenter',
            'networkBucket',
            'pipelineType',
            'name',
        ];
    }

    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {

        return AzureUsageReport::query()->whereKey($this->students);
    }
}
