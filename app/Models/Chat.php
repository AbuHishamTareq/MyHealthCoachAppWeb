<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Chat extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'chats';

    protected $fillable = [
        'id',
        'room_id',
        'sender_id',
        'message',
        'created_at',
        'updated_at'
    ];

    public function getSender() {
        return $this->BelongsTo('App\Models\Patient', 'sender_id');
    }
}
