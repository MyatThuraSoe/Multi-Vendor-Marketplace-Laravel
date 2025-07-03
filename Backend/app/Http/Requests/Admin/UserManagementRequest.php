<?php
// app/Http/Requests/Admin/UserManagementRequest.php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'is_active' => 'required|boolean',
            'role' => ['required', Rule::in(['admin', 'seller', 'buyer'])],
        ];
    }
}
