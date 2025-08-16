<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Iniciar sesión y generar token JWT
     */
    public function login(Request $request)
    {
        $request->validate([
            'acceso' => 'required|string',
            'secreto' => 'required|string',
        ]);

        $user = Usuario::where('acceso', $request->acceso)->first();

        if (!$user || !Hash::check($request->secreto, $user->secreto) || $user->estado != 1) {
            return response()->json(['error' => 'Credenciales inválidas.'], 401);
        }

        // Crear token manualmente si las credenciales están bien
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    /**
     * Obtener datos del usuario autenticado
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Cerrar sesión (invalidar token)
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Sesión cerrada con éxito']);
    }

    /**
     * Refrescar token
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Formato de respuesta con token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
