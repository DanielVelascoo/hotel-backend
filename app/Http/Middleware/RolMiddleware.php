<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol)
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol->nombre !== $rol) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return $next($request);
    }
}
