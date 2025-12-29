<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Create a new policy instance.
     * determina quien puede ver el campo para modificar
     */
    public function index(User $user) : bool
    {
        return !Auth::user()->id === $user->id;
        
    }
}
