<?php
// app/Http/Requests/ProductSearchRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort_by' => 'nullable|in:price_asc,price_desc,newest,oldest,rating,popularity',
            'per_page' => 'nullable|integer|min:1|max:100',
            'seller_id' => 'nullable|exists:users,id',
            'in_stock_only' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'min_price.min' => 'Minimum price cannot be negative.',
            'max_price.min' => 'Maximum price cannot be negative.',
            'per_page.max' => 'Cannot display more than 100 items per page.',
        ];
    }
}
