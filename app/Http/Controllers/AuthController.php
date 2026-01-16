<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsuarioToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'rol_id' => 'required|exists:roles,id',
    ]);

    $usuario = User::create([
        'nombre' => $request->nombre,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol_id' => $request->rol_id,
        'estado' => 'activo',
    ]);

    return response()->json([
        'mensaje' => 'Usuario creado correctamente',
        'usuario' => $usuario
    ], 201);
}

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // crear token
        $token = Str::random(60);

        UsuarioToken::create([
            'usuario_id' => $usuario->id,
            'token' => hash('sha256', $token),
            'tipo' => 'jwt',
            'expira_en' => now()->addHours(6),
        ]);

        return response()->json([
            'token' => $token,
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'rol' => $usuario->rol->nombre,
            ]
        ]);
    }
}
