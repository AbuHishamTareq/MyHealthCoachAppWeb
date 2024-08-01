<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserType extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user_types';

    protected $fillable = [
        'role',
        'created_by',
        'updated_by'
    ];

    public function getCreatedBy() {
        return $this->BelongsTo('App\Models\Admin', 'created_by');
    }

    public function getUpdatedBy() {
        return $this->BelongsTo('App\Models\Admin', 'updated_by');
    }
}
