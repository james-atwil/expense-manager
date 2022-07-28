<?php

namespace App\Http\Middleware;

use Closure;

class RoleCheck
{
    /**
     * @param           $request
     * @param  Closure  $next
     * @param           $roles
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles) : mixed
    {
        if ($request->user()->hasRole('admin')) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        abort(401);
    }
}
