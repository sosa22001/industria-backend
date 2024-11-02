<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use \stdClass;


class AuthuserController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400); // Cambié a 400 para errores de validación
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'data' => $user,
        'access_token' => 'Bearer ' . $token, // Asegúrate de incluir el token aquí
    ], 201); // Cambié a 201 para indicar que se creó un recurso
}

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) 
        {
            return response()
            ->json(['message' => 'No autorizado'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()
        ->json([
            'message' => 'Hi, ' . $user->name,
            'access_token' => $token,
             'token_type' => 'Bearer',
             'user' => $user,
            ], 200);
    }

    public function logout()
    {
        auth()->user()->Tokens()->delete();

        return[
            'message' => 'Has cerrado sesión exitosamente y el token se eliminó exitosamente'
        ];
    }
}
