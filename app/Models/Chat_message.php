<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\User;

class Chat_message extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'chat_room_id',
        //'sender_id',
        'user_id',
        'message_text',
        'created_at',
        'updated_at',
    ];
    public function chat_rooms(){
        return $this->hasMany(Chat_room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPaginateByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('user')->orderBy('updated_at', 'ASC')->get();
    }
}
