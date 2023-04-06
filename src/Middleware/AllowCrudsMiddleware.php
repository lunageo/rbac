<?php

namespace Luna\RBAC\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowCrudsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('luna-rbac.allow-cruds')) {
            return $next($request);
        }

        abort(403, config('luna-rbac.allow-cruds-msg'));
    }
}
