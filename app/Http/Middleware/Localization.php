<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\SupportedLanguages;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = SupportedLanguages::EN;

        if ($request->hasHeader('Accept-Language'))
            $locale = SupportedLanguages::tryFrom($request->header('Accept-Language'));

        if(!$locale)
            throw new BadRequestException(trans('messages.invalid_lang'));

        app()->setLocale($locale->value);

        return $next($request);
    }
}
