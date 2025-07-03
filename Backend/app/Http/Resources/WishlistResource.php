<?php
// app/Http/Resources/WishlistResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'items' => WishlistItemResource::collection($this->items),
            'items_count' => $this->items_count,
            'total_value' => $this->total_value,
            'formatted_total_value' => '$' . number_format($this->total_value, 2),
            'available_items' => $this->available_items,
            'out_of_stock_items' => $this->out_of_stock_items,
        ];
    }
}
