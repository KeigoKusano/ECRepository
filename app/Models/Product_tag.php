<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_tag extends Model
{
    use HasFactory;
    
    protected $table = 'product_tag';
    
    protected $fillable = [
        'product_id',
        'tag_id',
        'created_at',
        'updated_at',
    ];
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function getPaginateByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('tag')->orderBy('updated_at', 'ASC')->get();
    }
    
}
