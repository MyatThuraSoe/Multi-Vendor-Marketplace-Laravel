<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'amount',
        'status',
        'bank_details',
        'admin_notes',
        'approved_at',
        'processed_at',
    ];

    protected $casts = [
        'bank_details' => 'encrypted:array',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
