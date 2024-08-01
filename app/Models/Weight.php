<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Weight extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'weights';

    protected $fillable = [
        'id',
        'patient_id',
        'weight',
        'bmi',
        'read_date',
        'read_time',
        'created_at',
        'updated_at'
    ];
}
