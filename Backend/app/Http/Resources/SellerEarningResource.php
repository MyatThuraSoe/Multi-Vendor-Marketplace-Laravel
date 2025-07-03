<?php
// app/Http/Resources/SellerEarningResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerEarningResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'order_item_id' => $this->order_item_id,
            'gross_amount' => $this->gross_amount,
            'commission_rate' => $this->commission_rate,
            'commission_amount' => $this->commission_amount,
            'net_amount' => $this->net_amount,
            'formatted_net_amount' => '$' . number_format($this->net_amount, 2),
            'status' => $this->status,
            'available_at' => $this->available_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'order_item' => $this->when($this->relationLoaded('orderItem'), 
                new OrderItemResource($this->orderItem)
            ),
        ];
    }
}
