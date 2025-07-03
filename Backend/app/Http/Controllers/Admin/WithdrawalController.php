<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WithdrawalActionRequest;
use App\Models\Withdrawal;
use App\Http\Resources\WithdrawalResource;
use App\Http\Resources\ApiResponseResource;

class WithdrawalController extends Controller
{
    public function handleAction(WithdrawalActionRequest $request, Withdrawal $withdrawal)
    {
        $validated = $request->validated();
        $action = $validated['action']; // 'approve' or 'reject'

        if ($action === 'approve') {
            $withdrawal->status = 'approved';
            $withdrawal->approved_at = now();
        } else { // 'reject'
            $withdrawal->status = 'rejected';
        }

        $withdrawal->admin_notes = $validated['admin_notes'] ?? null;
        $withdrawal->save();

        return new ApiResponseResource(
            new WithdrawalResource($withdrawal),
            "Withdrawal has been successfully {$withdrawal->status}.",
            200
        );
    }
}
