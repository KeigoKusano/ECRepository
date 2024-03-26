<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_order extends Model
{
    use HasFactory;
    protected $fillable = [
        //'delivery',
        'postage',
        'number',
        'order_status',
        'chat_room_id',
        'product_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function chat_room()
    {
        return $this->belongsTo(Chat_room::class);
    }
    public function getPaginateByLimit()
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('product')->orderBy('updated_at', 'ASC')->get();
    }
    
}
