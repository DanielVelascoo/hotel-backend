<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioToken;
use App\Models\User;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Token requerido'], 401);
        }


        $tokenHash = hash('sha256', $token);

        $registro = UsuarioToken::where('token', $tokenHash)
            ->where('revocado', false)
            ->where('expira_en', '>', now())
            ->first();

        if (!$registro) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        // 🔥 AQUÍ está la magia correcta en Laravel 12
        $usuario = User::find($registro->usuario_id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }

        Auth::setUser($usuario);

        return $next($request);
    }
}
