<?php

namespace Luna\RBAC\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Luna\RBAC\Services\LunaPermissionsService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route as AppRoute;

class LunaPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (LunaPermissionsService::canAccess($user, AppRoute::current()->uri)) {
            return $next($request);
        }

        abort(401);
    }
}
