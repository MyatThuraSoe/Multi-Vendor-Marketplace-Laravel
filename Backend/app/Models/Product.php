<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'stock',
        'image_path',
        'gallery',
        'is_active',
        'weight',
        'attributes',
    ];

    protected $casts = [
        'gallery' => 'array',
        'attributes' => 'array',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
