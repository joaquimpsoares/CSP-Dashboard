<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\AzureUsageReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class exportAzure implements
    FromQuery
{
    use Exportable;
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {

        // dd($this->students);
        return AzureUsageReport::query()->whereKey($this->students);
    }
}
