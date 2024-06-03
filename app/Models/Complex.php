<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complex extends Model
{
    use HasFactory;

    protected $table = 'complexes';

    protected $fillable = [
        'name',
        'address',
        'region',
        'city',
        'phone_number',
        'latitude',
        'longitude',
        'status',
        'created_by',
        'updated_by'
    ];
}
