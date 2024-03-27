<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user)
                throw new AccessDeniedHttpException('Unauthorized authentication is required to this resource');

            if ($user->isTwoFAEnabled() && !$user->is2FAVerified())
                throw new AccessDeniedHttpException('Unauthorized access to this resource - 2FA not verified');

            return $next($request);
        } catch (\Throwable $e) {

            if ($e instanceof AccessDeniedHttpException) throw $e;

            throw new AccessDeniedHttpException($e->getMessage());
        }
    }
}
