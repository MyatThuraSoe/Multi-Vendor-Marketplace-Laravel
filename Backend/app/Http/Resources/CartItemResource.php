<?php
// app/Http/Resources/CartItemResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'formatted_unit_price' => '$' . number_format($this->unit_price, 2),
            'formatted_total' => '$' . number_format($this->total_price, 2),
            'max_quantity' => $this->max_quantity,
            'is_available' => $this->is_available,
            'availability_message' => $this->availability_message,
            'product' => new ProductListResource($this->product),
        ];
    }
}
