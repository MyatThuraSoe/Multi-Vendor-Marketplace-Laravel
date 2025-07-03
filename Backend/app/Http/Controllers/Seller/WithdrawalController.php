<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\WithdrawalRequest;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function request(WithdrawalRequest $request)
    {
        $withdrawal = Withdrawal::create([
            'seller_id' => auth()->id(),
            'amount' => $request->input('amount'),
            'bank_details' => encrypt(json_encode([
                'bank_name' => $request->input('bank_name'),
                'account_number' => $request->input('account_number'),
                'account_holder' => $request->input('account_holder'),
                'routing_number' => $request->input('routing_number'),
            ])),
            'status' => 'requested',
        ]);

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\WithdrawalResource($withdrawal),
            'Withdrawal requested successfully.',
            201
        );
    }
}
