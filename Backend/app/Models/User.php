<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'role',
        'is_active',
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
        'is_active' => 'boolean',
    ];

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'buyer_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'seller_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'buyer_id');
    }

    public function sellerEarnings()
    {
        return $this->hasMany(SellerEarning::class, 'seller_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function getAvailableEarningsAttribute()
    {
        return $this->withdrawals()
                    ->where('status', 'processed')
                    ->sum('amount');
    }
}
