<?php
// app/Http/Requests/Buyer/ReviewRequest.php
namespace App\Http\Requests\Buyer;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = Order::find($this->input('order_id'));
        return auth()->user()->isBuyer() && 
               $order && 
               $order->buyer_id === auth()->id() &&
               $order->status === 'delivered';
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Rating is required.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
            'comment.max' => 'Comment cannot exceed 1000 characters.',
        ];
    }
}
