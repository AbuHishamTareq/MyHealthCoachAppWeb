<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Step extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'steps';

    protected $fillable = [
        'id',
        'patient_id',
        'steps',
        'read_date',
        'read_time',
        'created_at',
        'updated_at'
    ];
}
