<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Authenticate extends Middleware
{


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?AccessDeniedHttpException
    {
        if (!$request->expectsJson()) {
            throw new AccessDeniedHttpException('Unauthorized access to this resource');
        }

        return null;
    }
}
