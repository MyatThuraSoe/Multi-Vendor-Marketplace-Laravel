<?php
// app/Http/Resources/UserResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'is_active' => $this->is_active,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'seller_profile' => $this->when($this->relationLoaded('sellerProfile'), 
                new SellerProfileResource($this->sellerProfile)
            ),
            'total_earnings' => $this->when($this->isSeller(), $this->total_earnings),
            'available_earnings' => $this->when($this->isSeller(), $this->available_earnings),
        ];
    }
}
