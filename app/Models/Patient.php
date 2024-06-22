<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'uid',
        'name',
        'password',
        'mobile',
        'region',
        'city',
        'address',
        'blood_group',
        'coach_id',
        'complex_id',
        'birth_date',
        'status'
    ];
}
