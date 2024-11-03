<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{

    // Método para obtener todos los proveedores
    public function index(){
        // Obtener todos los proveedores
        $proveedores = Proveedor::all();

        // Verificar si la colección está vacía
        if ($proveedores->isEmpty()) {
            return response()->json(['message' => 'No hay proveedores registrados'], 404);
        }

        // Retornar la lista de proveedores
        return response()->json($proveedores, 200);
    }

    public function create(Request $request){
        // Validar los datos de la petición
        $request->validate([
            'nombre_proveedor' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|boolean',
            'direccion' => 'required|string|max:255',
        ]);

        // Crear un nuevo proveedor
        $proveedor = Proveedor::create([
            'nombre_proveedor' => $request->nombre_proveedor,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'estado' => $request->estado,
            'direccion' => $request->direccion,
        ]);

        // Verificar si el proveedor fue creado exitosamente
        if ($proveedor) {
            // Retornar la respuesta con el proveedor creado y código 201
            return response()->json($proveedor, 201);
        } else {
            // Retornar un mensaje de error si la creación falla
            return response()->json([
                'message' => 'No se pudo crear el proveedor. Inténtalo de nuevo más tarde.'
            ], 500); // Código 500 para error interno del servidor
        }
    }

    public function show($id){
        // Buscar un proveedor por su ID
        $proveedor = Proveedor::find($id);

        // Verificar si el proveedor no existe
        if (!$proveedor) {
            return response()->json(['message' => 'No se encontró el proveedor con el ID proporcionado'], 404);
        }

        // Retornar el proveedor encontrado
        return response()->json($proveedor, 200);
    }


    public function update(Request $request, $id){
        // Buscar un proveedor por su ID
        $proveedor = Proveedor::find($id);

        // Verificar si el proveedor no existe
        if (!$proveedor) {
            return response()->json(['message' => 'No se encontró el proveedor con el ID proporcionado'], 404);
        }

        // Validar los datos de la petición
        $request->validate([
            'nombre_proveedor' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'estado' => 'required|boolean',
            'direccion' => 'required|string|max:255',
        ]);

        // Actualizar los datos del proveedor
        $proveedor->nombre_proveedor = $request->nombre_proveedor;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->estado = $request->estado;
        $proveedor->direccion = $request->direccion;

        // Guardar los cambios en la base de datos
        $proveedor->save();

        // Retornar el proveedor actualizado
        return response()->json($proveedor, 200);
    }

    public function delete($id){
        // Buscar un proveedor por su ID
        $proveedor = Proveedor::find($id);

        // Verificar si el proveedor no existe
        if (!$proveedor) {
            return response()->json(['message' => 'No se encontró el proveedor con el ID proporcionado'], 404);
        }

        // Eliminar el proveedor de la base de datos
        $proveedor->delete();

        // Retornar un mensaje de éxito
        return response()->json(['message' => 'Proveedor eliminado correctamente'], 200);
    }
}
