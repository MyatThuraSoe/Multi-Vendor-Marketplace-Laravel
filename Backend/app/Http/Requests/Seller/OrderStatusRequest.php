<?php
// app/Http/Requests/Seller/OrderStatusRequest.php
namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');
        return auth()->user()->isSeller() && 
               $order->items()->where('seller_id', auth()->id())->exists();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['processing', 'shipped', 'delivered'])],
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
