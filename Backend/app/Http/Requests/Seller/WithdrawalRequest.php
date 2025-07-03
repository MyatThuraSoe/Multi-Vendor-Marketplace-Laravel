<?php
// app/Http/Requests/Seller/WithdrawalRequest.php
namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isSeller() && 
               auth()->user()->sellerProfile?->is_approved;
    }

    public function rules(): array
    {
        $maxAmount = auth()->user()->available_earnings;
        
        return [
            'amount' => "required|numeric|min:10|max:{$maxAmount}",
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'routing_number' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum withdrawal amount is $10.',
            'amount.max' => 'Withdrawal amount cannot exceed your available earnings.',
        ];
    }
}
