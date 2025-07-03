<?php
// app/Http/Resources/TaxRateResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxRateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rate' => $this->rate,
            'is_active' => $this->is_active,
            'country' => $this->country,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'priority' => $this->priority,
            'is_compound' => $this->is_compound,
            'is_shipping_taxable' => $this->is_shipping_taxable,
        ];
    }
}
