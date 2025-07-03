<?php
// app/Http/Requests/Auth/SellerRegistrationRequest.php
namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SellerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_name' => 'required|string|max:255|unique:seller_profiles,store_name',
            'bio' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'store_name.required' => 'Store name is required.',
            'store_name.unique' => 'This store name is already taken.',
            'logo.image' => 'Logo must be a valid image file.',
            'logo.max' => 'Logo file size cannot exceed 2MB.',
        ];
    }
}
