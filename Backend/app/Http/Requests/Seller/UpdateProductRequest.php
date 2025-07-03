<?php
// app/Http/Requests/Seller/UpdateProductRequest.php
namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product');
        return auth()->user()->isSeller() && 
               auth()->user()->sellerProfile?->is_approved &&
               $product->seller_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array|max:5',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required_with:attributes|string|max:50',
            'attributes.*.value' => 'required_with:attributes|string|max:100',
            'is_active' => 'required|boolean',
        ];
    }
}
