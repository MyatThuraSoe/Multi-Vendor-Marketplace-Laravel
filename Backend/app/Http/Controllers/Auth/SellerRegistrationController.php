<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SellerRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerRegistrationController extends Controller
{
    public function register(SellerRegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'seller',
            'is_active' => false,
        ]);

        $user->sellerProfile()->create([
            'store_name' => $request->input('store_name'),
            'bio' => $request->input('bio'),
            'logo_path' => $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null,
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\UserResource($user),
            'Seller registration successful. Awaiting admin approval.',
            201
        );
    }
}
