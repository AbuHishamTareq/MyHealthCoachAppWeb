<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Complex extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

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
