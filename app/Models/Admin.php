<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'uid',
        'email',
        'password',
        'name',
        'address',
        'mobile',
        'user_type',
        'complex_id',
        'created_by',
        'updated_by',
        'image_url',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
