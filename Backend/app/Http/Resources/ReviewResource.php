<?php
// app/Http/Resources/ReviewResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'buyer_id' => $this->buyer_id,
            'product_id' => $this->product_id,
            'order_id' => $this->order_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'buyer' => $this->when($this->relationLoaded('buyer'), [
                'id' => $this->buyer->id,
                'name' => $this->buyer->name,
            ]),
            'product' => $this->when($this->relationLoaded('product'), [
                'id' => $this->product->id,
                'title' => $this->product->title,
                'slug' => $this->product->slug,
            ]),
        ];
    }
}
