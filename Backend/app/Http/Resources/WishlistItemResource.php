<?php
// app/Http/Resources/WishlistItemResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'added_at' => $this->created_at,
            'is_available' => $this->is_available,
            'price_changed' => $this->price_changed,
            'original_price' => $this->original_price,
            'current_price' => $this->current_price,
            'product' => new ProductListResource($this->product),
        ];
    }
}
