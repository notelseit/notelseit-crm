<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'role', 'password', 'api_token'
    ];
    protected $hidden = ['password', 'api_token'];
}