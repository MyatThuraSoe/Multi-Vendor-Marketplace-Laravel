<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'buyer_id',
        'subtotal',
        'tax_amount',
        'shipping_fee',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'billing_address',
        'notes',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function getCanBeShippedAttribute()
    {
        return $this->status === 'processing';
    }

    public function getCanBeDeliveredAttribute()
    {
        return $this->status === 'shipped';
    }
}
