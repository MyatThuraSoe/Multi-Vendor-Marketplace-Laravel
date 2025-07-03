<?php
// app/Http/Resources/ShippingMethodResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => '$' . number_format($this->price, 2),
            'estimated_days' => $this->estimated_days,
            'is_available' => $this->is_available,
            'zones' => $this->zones,
            'restrictions' => $this->restrictions,
        ];
    }
}
