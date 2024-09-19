<?php

namespace App\Observers;

use App\Models\Enums\RoleCode;
use App\Models\Role;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user): void
    {
        $role = Role::query()->where('code', RoleCode::Customer)->first();
        $user->roles()->attach($role->getKey());
    }
}
