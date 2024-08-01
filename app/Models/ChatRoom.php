<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ChatRoom extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'chat_rooms';

    protected $fillable = [
        'id',
        'name',
        'created_by',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getCreatedBy() {
        return $this->BelongsTo('App\Models\Admin', 'created_by');
    }
}
