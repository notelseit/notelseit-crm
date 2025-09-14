<?php

namespace App\Policies;

use App\Models\User;

class SettingPolicy
{
    public function view(User $user)
    {
        return in_array($user->role, ['admin', 'secretary']);
    }

    public function update(User $user)
    {
        return $user->role === 'admin';
    }
}