<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o utilizador não estiver logado ou o cargo dele não estiver na lista permitida
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Não tens permissão para aceder a esta página.');
        }

        return $next($request);
    }
}
