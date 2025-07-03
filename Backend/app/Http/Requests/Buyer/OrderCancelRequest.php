<?php
// app/Http/Requests/Buyer/OrderCancelRequest.php
namespace App\Http\Requests\Buyer;

use Illuminate\Foundation\Http\FormRequest;

class OrderCancelRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');
        return auth()->user()->isBuyer() && 
               $order->buyer_id === auth()->id() &&
               $order->can_be_cancelled;
    }

    public function rules(): array
    {
        return [
            'reason' => 'required|string|max:500',
        ];
    }
}
