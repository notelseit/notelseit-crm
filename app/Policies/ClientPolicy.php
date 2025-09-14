<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;

class ClientPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('commerciale');
    }

    public function view(User $user, Client $client)
    {
        return true; // tutti possono vedere i clienti
    }

    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('commerciale');
    }

    public function update(User $user, Client $client)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Client $client)
    {
        return $user->hasRole('admin');
    }
}