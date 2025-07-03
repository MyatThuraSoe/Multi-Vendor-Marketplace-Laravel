<?php
// app/Http/Resources/PaymentResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'payment_id' => $this->payment_id,
            'provider' => $this->provider,
            'amount' => $this->amount,
            'formatted_amount' => '$' . number_format($this->amount, 2),
            'status' => $this->status,
            'transaction_id' => $this->transaction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Hide sensitive provider response from non-admin users
            'provider_response' => $this->when(
                auth()->user()?->isAdmin(),
                $this->provider_response
            ),
        ];
    }
}
