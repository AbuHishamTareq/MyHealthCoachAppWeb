<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientParameter extends Model
{
    use HasFactory;

    protected $table = 'patient_parameters';

    protected $fillable = [
        'patient_id',
        'bp_systolic',
        'bp_distolic',
        'rbs',
        'weight',
        'bmi',
        'read_date',
        'read_time'
    ];
}
