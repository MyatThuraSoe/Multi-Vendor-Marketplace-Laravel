<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_id',
        'provider',
        'amount',
        'status',
        'provider_response',
        'transaction_id',
    ];

    protected $casts = [
        'provider_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
