<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_Connection extends Model
{
    use HasFactory;

    protected $table = 'message_connection';
    protected $guarded = ['id'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'receiver_id')->select(['id', 'username', 'foto_profil', 'connection_id']);
    }
}
