<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'delivery',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function products()   
    {
        return $this->hasMany(Product::class);  
    }
    public function product_orders()   
    {
        return $this->hasMany(Product_order::class);  
    }
    public function getByUser()
    {
        return $this->product_orders()->with('user');
    }
    public function review_user_products()   
    {
        return $this->hasMany(Review_user_product::class);  
    }
    public function chat_room()
    {
        return $this->belongsTo(Chat_room::class);
    }
    public function getByChat()
    {
        return $this->chat_room()->with('user');
    }
    public function chat_message()
    {
        return $this->belongsTo(Chat_message::class);
    }
    public function getByMessage()
    {
        return $this->chat_message()->with('user');
    }
}
