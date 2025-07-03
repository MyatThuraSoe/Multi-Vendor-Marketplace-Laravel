<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'order_item_id',
        'gross_amount',
        'commission_rate',
        'commission_amount',
        'net_amount',
        'status',
        'available_at',
    ];

    protected $casts = [
        'available_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
