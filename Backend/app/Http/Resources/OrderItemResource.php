<?php
// app/Http/Resources/OrderItemResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'seller_id' => $this->seller_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'formatted_total' => '$' . number_format($this->total_price, 2),
            'product_snapshot' => $this->product_snapshot,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'product' => $this->when($this->relationLoaded('product'), 
                new ProductResource($this->product)
            ),
            'seller' => $this->when($this->relationLoaded('seller'), 
                new UserResource($this->seller)
            ),
        ];
    }
}
