<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FailedCustomersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $failedCustomers;

    /**
     * FailedCustomersExport constructor.
     * @param $failedCustomers
     */
    public function __construct($failedCustomers)
    {
        $this->failedCustomers = $failedCustomers;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection($this->failedCustomers);
    }

    public function map($row): array{
        return [
            $row[0],
            $row[1]
        ];
    }

    public function headings(): array
    {
        return [
            'Email',
            'Error'
        ];
    }
}
