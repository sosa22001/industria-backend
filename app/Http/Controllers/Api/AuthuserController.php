<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use \stdClass;
use Spatie\Permission\Models\Role;



class AuthuserController extends Controller
{
    //----------------------------------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------------
    // Registro de usuario
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

//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------

    // Inicio de sesión
    public function login(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) 
    {
        return response()
            ->json(['message' => 'No autorizado'], 401);
    }

    $user = User::where('email', $request['email'])->with('roles:name')->firstOrFail();

    $token = $user->createToken('authToken')->plainTextToken;

    return response()
        ->json([
            'message' => 'Hi, ' . $user->name,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->pluck('name')->first() ?? 'Sin rol', // Incluye el nombre del rol
            ],
        ], 200);
}
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------

    // Cierre de sesión

    public function logout()
    {
        auth()->user()->Tokens()->delete();

        return[
            'message' => 'Has cerrado sesión exitosamente y el token se eliminó exitosamente'
        ];
    }


    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    // Listar usuarios

    public function index()
{
    return User::with('roles:name')->get()->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->pluck('name')->first() ?? 'Sin rol',
        ];
    });
}
//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------

    // Mostrar usuario por id
    public function show($id)
    {
        return User::find($id);
    }

//------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------
    // Asignar rol a usuario

    public function asignarRol(Request $request, $id)
{
    try {
        // Verificar si el usuario existe
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        // Obtener el rol desde el request
        $role = $request->input('role');
        if (!$role) {
            return response()->json(['error' => 'No se proporcionó un rol.'], 400);
        }

        // Verificar si el rol existe
        $roleModel = Role::where('name', $role)->first();
        if (!$roleModel) {
            return response()->json(['error' => 'El rol especificado no existe.'], 404);
        }

        // Asignar el rol al usuario
        $user->syncRoles([$role]);
        return response()->json([
            'message' => 'Rol asignado correctamente.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(), // Devuelve los roles asignados al usuario
            ],
        ], 200);
    } catch (\Exception $e) {
        // Manejo de errores genéricos
        return response()->json([
            'error' => 'Ocurrió un error al asignar el rol.',
            'details' => $e->getMessage(),
        ], 500);
    }
}

}
