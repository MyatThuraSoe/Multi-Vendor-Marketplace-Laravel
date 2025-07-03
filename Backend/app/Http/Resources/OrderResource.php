<?php
// app/Http/Resources/OrderResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'buyer_id' => $this->buyer_id,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'shipping_fee' => $this->shipping_fee,
            'total_price' => $this->total_price,
            'formatted_total' => '$' . number_format($this->total_price, 2),
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'notes' => $this->notes,
            'shipped_at' => $this->shipped_at,
            'delivered_at' => $this->delivered_at,
            'can_be_cancelled' => $this->can_be_cancelled,
            'can_be_shipped' => $this->can_be_shipped,
            'can_be_delivered' => $this->can_be_delivered,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'buyer' => $this->when($this->relationLoaded('buyer'), 
                new UserResource($this->buyer)
            ),
            'items' => $this->when($this->relationLoaded('items'), 
                OrderItemResource::collection($this->items)
            ),
            'payments' => $this->when($this->relationLoaded('payments'), 
                PaymentResource::collection($this->payments)
            ),
        ];
    }
}
