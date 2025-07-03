<?php
// app/Http/Resources/WithdrawalResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'amount' => $this->amount,
            'formatted_amount' => '$' . number_format($this->amount, 2),
            'status' => $this->status,
            'bank_details' => $this->when(
                auth()->user()->isAdmin() || auth()->id() === $this->seller_id,
                $this->bank_details
            ),
            'admin_notes' => $this->admin_notes,
            'approved_at' => $this->approved_at,
            'processed_at' => $this->processed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'seller' => $this->when($this->relationLoaded('seller'), 
                new UserResource($this->seller)
            ),
        ];
    }
}
