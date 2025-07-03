<?php
// app/Http/Resources/CartResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'items' => CartItemResource::collection($this->items),
            'items_count' => $this->items_count,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'shipping_fee' => $this->shipping_fee,
            'total' => $this->total,
            'formatted_subtotal' => '$' . number_format($this->subtotal, 2),
            'formatted_tax' => '$' . number_format($this->tax_amount, 2),
            'formatted_shipping' => '$' . number_format($this->shipping_fee, 2),
            'formatted_total' => '$' . number_format($this->total, 2),
            'sellers' => $this->sellers, // Group items by seller
            'has_out_of_stock' => $this->has_out_of_stock,
            'has_inactive_products' => $this->has_inactive_products,
        ];
    }
}
