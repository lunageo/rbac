<?php

namespace Luna\Permissions\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route as AppRoute;
use Luna\Permissions\Services\LunaPermissionsService;

class LunaPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (LunaPermissionsService::canAccess(AppRoute::current())) {
            return $next($request);
        }

        abort(401);
    }
}
