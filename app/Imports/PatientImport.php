<?php

namespace App\Imports;

use App\Models\Admin;
use App\Models\Complex;
use App\Models\Patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PatientImport implements ToModel, WithHeadingRow, WithChunkReading, WithUpserts
{
    private $coaches;
    private $complexes;

    public $rowCount = 0;

    public function __construct()
    {
        $this->coaches = Admin::select('id', 'name')->get();
        $this->complexes = Complex::select('id', 'name')->get();    
    }
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
        $row['created_by'] = auth()->guard('admin')->user()->id;

        $coach = $this->coaches->where('name', $row['coach_name'])->first();
        $complex = $this->complexes->where('name', $row['complex_name'])->first();

        ++$this->rowCount;

        return new Patient([
            'uid' => $row['uid'],
            'name' => $row['name'],
            'gender' => $row['gender'],
            'height' => $row['height'],
            'password' => $row['password'],
            'mobile' => $row['mobile'],
            'region' => $row['region'],
            'city' => $row['city'],
            'address' => $row['address'],
            'blood_group' => $row['blood_group'],
            'coach_id' => $coach->id ?? NULL,
            'complex_id' => $complex->id ?? NULL,
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

    public function getRowCount(): int {
        return $this->rowCount;
    }
}
