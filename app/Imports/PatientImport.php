<?php

namespace App\Imports;

use App\Models\Patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PatientImport implements ToModel, WithHeadingRow, WithChunkReading, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birth_date']);
        $row['birth_date'] = $date->format('Y-m-d');
        $row['password'] = bcrypt("123456"); 
        
        return new Patient([
            'uid' => $row['uid'],
            'name' => $row['name'],
            'gender' => $row['gender'],
            'password' => $row['password'],
            'mobile' => $row['mobile'],
            'region' => $row['region'],
            'city' => $row['city'],
            'address' => $row['address'],
            'blood_group' => $row['blood_group'],
            'coach_id' => $row['coach_id'],
            'complex_id' => $row['complex_id'],
            'birth_date' => $row['birth_date'],
            'status' => $row['status'],
            'created_by' => $row['created_by'],
            'updated_by' => $row['updated_by']
        ]);
    }

    public function chunkSize() : int {
        return 500;
    }

    public function uniqueBy()
    {
        return 'uid';
    }
}
