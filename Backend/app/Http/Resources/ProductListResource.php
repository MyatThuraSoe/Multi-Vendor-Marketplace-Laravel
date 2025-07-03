<?php
// app/Http/Resources/ProductListResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'formatted_price' => '$' . number_format($this->price, 2),
            'stock' => $this->stock,
            'is_in_stock' => $this->is_in_stock,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'average_rating' => round($this->average_rating, 1),
            'review_count' => $this->review_count,
            'seller' => [
                'id' => $this->seller->id,
                'name' => $this->seller->name,
                'store_name' => $this->seller->sellerProfile?->store_name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ],
        ];
    }
}
