<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'patients';

    protected $fillable = [
        'uid',
        'name',
        'gender',
        'height',
        'password',
        'mobile',
        'region',
        'city',
        'address',
        'blood_group',
        'step_target',
        'coach_id',
        'complex_id',
        'birth_date',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getComplex() {
        return $this->BelongsTo('App\Models\Complex', 'complex_id');
    }

    public function getCoach() {
        return $this->BelongsTo('App\Models\Admin', 'coach_id');
    }
}
