<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\User;

class Chat_room extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user1_id',
        'user2_id',
        'created_at',
        'updated_at',
    ];
    public function users(){
    //生徒は多数の科目を履修。
        return $this->hasMany(User::class);
    }
    public function chat_message()
    {
        return $this->belongsTo(Chat_message::class);
    }
}
