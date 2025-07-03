<?php
// app/Http/Resources/ProductResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => '$' . number_format($this->price, 2),
            'stock' => $this->stock,
            'is_in_stock' => $this->is_in_stock,
            'image_path' => $this->image_path,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'gallery' => $this->gallery ? collect($this->gallery)->map(fn($path) => asset('storage/' . $path)) : [],
            'is_active' => $this->is_active,
            'weight' => $this->weight,
            'attributes' => $this->attributes,
            'average_rating' => round($this->average_rating, 1),
            'review_count' => $this->review_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'seller' => $this->when($this->relationLoaded('seller'), 
                new UserResource($this->seller)
            ),
            'category' => $this->when($this->relationLoaded('category'), 
                new CategoryResource($this->category)
            ),
            'reviews' => $this->when($this->relationLoaded('reviews'), 
                ReviewResource::collection($this->reviews)
            ),
        ];
    }
}
