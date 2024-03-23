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
        'reciver_id',
        'created_at',
        'updated_at',
    ];
    /*public function users(){
        return $this->hasMany(User::class);
    }*/
    public function chat_message()
    {
        return $this->hasMany(Chat_message::class);
    }
    public function product_orders()
    {
        return $this->hasMany(Product_order::class);
    }
}
