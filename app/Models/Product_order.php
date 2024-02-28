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
        'order_status',
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
    public function getPaginateByLimit()//int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('user');//->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
}
