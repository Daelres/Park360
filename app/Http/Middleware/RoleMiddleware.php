<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $allowedRoles = collect($roles)
            ->flatMap(fn (string $role) => explode('|', $role))
            ->map(fn (string $role) => strtolower(trim($role)))
            ->filter()
            ->values();

        if ($allowedRoles->isEmpty()) {
            return $next($request);
        }

        if (! $user || ! $user->hasAnyRole($allowedRoles->all())) {
            if ($request->expectsJson()) {
                abort(Response::HTTP_FORBIDDEN);
            }

            return redirect()->route('public.home')->with('warning', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
