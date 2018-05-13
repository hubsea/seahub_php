<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     *  author:HAHAXIXI
     *  created_at: 2018-5-12
     *  updated_at: 2018-6-
     * @param User $currentUser
     * @param User $user
     * @return bool
     *  desc   :
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
