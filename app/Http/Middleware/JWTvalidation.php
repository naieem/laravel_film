<?php

namespace App\Http\Middleware;

use Closure;
use JWT;
use JWTAuth;
class JWTvalidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $decryptedToken = JWTAuth::toUser($token);
        return response($decryptedToken,200);
    }
}
