<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Withdrawal $withdrawal)
    {
        return $user->id === $withdrawal->seller_id || $user->isAdmin();
    }
}
