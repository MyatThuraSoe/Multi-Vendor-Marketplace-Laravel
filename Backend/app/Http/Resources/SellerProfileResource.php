<?php
// app/Http/Resources/SellerProfileResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'store_name' => $this->store_name,
            'logo_path' => $this->logo_path,
            'logo_url' => $this->logo_path ? asset('storage/' . $this->logo_path) : null,
            'bio' => $this->bio,
            'status' => $this->status,
            'is_approved' => $this->is_approved,
            'approved_at' => $this->approved_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->when($this->relationLoaded('user'), 
                new UserResource($this->user)
            ),
        ];
    }
}
