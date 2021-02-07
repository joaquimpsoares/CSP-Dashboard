<?php

namespace App\Exports;
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 300);
use App\Models\Student;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class exportAzure implements FromQuery, WithHeadings, WithMapping

{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'name',
            'Resource_Group',
            'resource_location',
            'resource_id',
            'resource_name',
            'resource_category',
            'resource_subcategory',
            'resource_region',
            'quantity',
            'unit',
            'resourceType',
            'usageResourceKind',
            'dataCenter',
            'networkBucket',
            'pipelineType',
            'cost',
            'usageStartTime',
            'usageEndTime',
        ];
    }

    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function map($students): array
    {
        return [
            $students->subscription_id,
            $students->name,
            $students->resource_group,
            $students->resource_location,
            $students->resource_id,
            $students->resource_name,
            $students->resource_category,
            $students->resource_subcategory,
            $students->resource_region,
            $students->quantity,
            $students->unit,
            $students->resourceType,
            $students->usageResourceKind,
            $students->dataCenter,
            $students->networkBucket,
            $students->pipelineType,
            $students->cost,
            $students->usageStartTime,
            $students->usageEndTime,

        ];
    }


    public function query()
    {

        return AzureUsageReport::query()->whereKey($this->students);
    }
}
