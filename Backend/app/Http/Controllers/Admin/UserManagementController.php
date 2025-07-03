<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserManagementRequest;
use App\Models\User;

class UserManagementController extends Controller
{
    public function update(UserManagementRequest $request, User $user)
    {
        $user->update([
            'role' => $request->input('role'),
            'is_active' => $request->input('is_active'),
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\UserResource($user),
            'User updated successfully.',
            200
        );
    }
}
