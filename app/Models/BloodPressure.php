<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BloodPressure extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'blood_pressures';

    protected $fillable = [
        'id',
        'patient_id',
        'systolic',
        'distolic',
        'read_date',
        'read_time',
        'created_at',
        'updated_at'
    ];
}
