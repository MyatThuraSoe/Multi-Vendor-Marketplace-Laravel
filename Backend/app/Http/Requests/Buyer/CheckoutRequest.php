<?php
// app/Http/Requests/Buyer/CheckoutRequest.php
namespace App\Http\Requests\Buyer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isBuyer();
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            
            'payment_method' => ['required', Rule::in(['stripe', 'paypal', 'cash_on_delivery'])],
            
            'shipping_address' => 'required|array',
            'shipping_address.first_name' => 'required|string|max:50',
            'shipping_address.last_name' => 'required|string|max:50',
            'shipping_address.address_line_1' => 'required|string|max:100',
            'shipping_address.address_line_2' => 'nullable|string|max:100',
            'shipping_address.city' => 'required|string|max:50',
            'shipping_address.state' => 'required|string|max:50',
            'shipping_address.postal_code' => 'required|string|max:20',
            'shipping_address.country' => 'required|string|max:50',
            'shipping_address.phone' => 'nullable|string|max:20',
            
            'billing_address' => 'required|array',
            'billing_address.first_name' => 'required|string|max:50',
            'billing_address.last_name' => 'required|string|max:50',
            'billing_address.address_line_1' => 'required|string|max:100',
            'billing_address.address_line_2' => 'nullable|string|max:100',
            'billing_address.city' => 'required|string|max:50',
            'billing_address.state' => 'required|string|max:50',
            'billing_address.postal_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:50',
            
            'use_shipping_for_billing' => 'boolean',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Cart cannot be empty.',
            'items.*.product_id.exists' => 'One or more products in your cart no longer exist.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'shipping_address.*.required' => 'All shipping address fields are required.',
            'billing_address.*.required' => 'All billing address fields are required.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->boolean('use_shipping_for_billing')) {
            $this->merge([
                'billing_address' => $this->input('shipping_address', [])
            ]);
        }
    }
}
