<?php

namespace App\Policies;

use App\Models\Ladder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LadderPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ladder  $ladder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ladder $ladder)
    {
        //
    }
}
