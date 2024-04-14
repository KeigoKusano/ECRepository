<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tag',
        'created_at',
        'updated_at',
    ];
    public function products(){
    //1つの科目を多数の生徒が履修。
        return $this->belongsToMany(Product::class);
    }
}
