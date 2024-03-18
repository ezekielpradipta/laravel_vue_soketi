<?php

namespace App\Claims;

use App\Models\User;
use CorBosman\Passport\AccessToken;

class AuthClaim
{
    public function handle(AccessToken $token, $next)
    {
        $user = User::find($token->getUserIdentifier());
        $token->addClaim('role_name', $user->role_user->role->role_name);


        return $next($token);
    }
}
