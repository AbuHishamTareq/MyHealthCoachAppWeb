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
        'email',
        'password',
        'name',
        'mobile',
        'user_type',
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
