<?php
// app/Http/Requests/Seller/ProductRequest.php
namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isSeller() && 
               auth()->user()->sellerProfile?->is_approved;
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

    public function messages(): array
    {
        return [
            'title.required' => 'Product title is required.',
            'price.min' => 'Price must be at least $0.01.',
            'price.max' => 'Price cannot exceed $999,999.99.',
            'stock.min' => 'Stock cannot be negative.',
            'category_id.exists' => 'Selected category does not exist.',
            'image.image' => 'Product image must be a valid image file.',
            'gallery.max' => 'You can upload maximum 5 gallery images.',
            'gallery.*.image' => 'All gallery files must be valid images.',
        ];
    }
}
