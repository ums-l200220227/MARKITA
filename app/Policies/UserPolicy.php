<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the target user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $targetUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $targetUser)
    {
        // Hanya admin yang bisa mengedit pengguna lain, atau pengguna yang bersangkutan yang bisa mengedit data mereka sendiri
        return $user->id === $targetUser->id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the target user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $targetUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $targetUser)
    {
        // Hanya admin yang bisa menghapus pengguna lain
        return $user->role === 'admin';
    }
}

