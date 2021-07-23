<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return bool
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('customers')->updateOrInsert(
                ['email' => $row['email']],
                [
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone_number' => $row['phone_number'],
                ]
            );
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
            'phone_number' => [
                'required',
                'max:15'
            ]
        ];
    }
}
