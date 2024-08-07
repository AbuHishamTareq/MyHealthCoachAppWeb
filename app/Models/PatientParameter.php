<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PatientParameter extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'patient_parameters';

    protected $fillable = [
        'patient_id',
        'bp_systolic',
        'bp_distolic',
        'rbs',
        'weight',
        'bmi',
        'steps',
        'read_date',
        'read_time'
    ];
}
