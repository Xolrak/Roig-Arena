<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required_without:nombre|string|max:255',
            'nombre' => 'required_without:name|string|max:255',
            'apellido' => 'required_without:name|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        [$nombre, $apellido] = $this->normalizarNombreCompleto($request);

        $user = User::create([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => trim($user->nombre . ' ' . $user->apellido),
                'email' => $user->email,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Iniciar sesión
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales son incorrectas.',
            ], 401);
        }

        // Eliminar tokens anteriores (opcional)
        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => trim($user->nombre . ' ' . $user->apellido),
                'email' => $user->email,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }

    /**
     * Obtener usuario autenticado
     */
    public function user(Request $request)
    {
        return response()->json([
            'data' => new \App\Http\Resources\UserResource($request->user()),
        ]);
    }

    private function normalizarNombreCompleto(Request $request): array
    {
        if ($request->filled('name')) {
            $partes = preg_split('/\s+/', trim($request->name), 2);

            return [
                $partes[0] ?? $request->name,
                $partes[1] ?? '',
            ];
        }

        return [
            $request->nombre,
            $request->apellido,
        ];
    }
}