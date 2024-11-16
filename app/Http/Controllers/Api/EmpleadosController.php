<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    // Método para obtener todos los empleados

    public function index()
    {
        // Obtener todos los empleados con su puesto relacionado
        $empleados = Empleado::with('puesto')->get();
    
        // Verificar si la colección está vacía
        if ($empleados->isEmpty()) {
            return response()->json(['message' => 'No hay empleados registrados'], 404);
        }
    
        // Mapear la respuesta para incluir todos los campos solicitados
        $empleadosConPuesto = $empleados->map(function ($empleado) {
            return [
                'id' => $empleado->id,
                'dni_empleado' => $empleado->dni_empleado,
                'primer_nombre' => $empleado->primer_nombre,
                'segundo_nombre' => $empleado->segundo_nombre,
                'primer_apellido' => $empleado->primer_apellido,
                'segundo_apellido' => $empleado->segundo_apellido,
                'puesto' => $empleado->puesto ? $empleado->puesto->nombre_del_puesto : 'No asignado', // Si el puesto no está asignado
                'estado' => $empleado->estado,
                'direccion' => $empleado->direccion,
                'email' => $empleado->email,
                'telefono' => $empleado->telefono,
                'fecha_nacimiento' => $empleado->fecha_nacimiento,
                'fecha_ingreso' => $empleado->fecha_ingreso,
                'rtn' => $empleado->rtn,
                'usuario' => $empleado->usuario ? $empleado->usuario->name : 'No asignado',
            ];
        });
    
        // Retornar los datos con todos los campos solicitados
        return response()->json($empleadosConPuesto, 200);
    }
    


    // Método para crear un nuevo empleado


    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'dni_empleado' => 'required|string|max:255|unique:empleados,dni_empleado',
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'id_puesto' => 'required|exists:puestos,id',
            'estado' => 'required|boolean',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:empleados,email',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'fecha_ingreso' => 'required|date',
            'rtn' => 'required|string|max:50',
            'id_user' => 'required|exists:users,id',
        ]);

        // Asignar el usuario autenticado al campo created_by si corresponde
        // Esto supone que estás usando autenticación
        $validatedData['created_by'] = auth()->id();

        // Crear el empleado
        $empleado = Empleado::create($validatedData);

        // Verificar si el empleado fue creado exitosamente
        if ($empleado) {
            // Retornar la respuesta con el empleado creado y código 201
            return response()->json($empleado, 201);
        } else {
            // Retornar un mensaje de error si la creación falla
            return response()->json([
                'message' => 'No se pudo crear el empleado. Inténtalo de nuevo más tarde.'
            ], 500); // Código 500 para error interno del servidor
        }
    }

    // Método para obtener un empleado por su ID

    public function show($id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::find($id);

        // Verificar si el empleado existe
        if ($empleado) {
            // Retornar el empleado encontrado
            return response()->json($empleado, 200);
        } else {
            // Retornar un mensaje de error si el empleado no existe
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
    }


    // Método para actualizar un empleado por su ID

    public function update(Request $request, $id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::find($id);

        // Verificar si el empleado existe
        if ($empleado) {
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'dni_empleado' => 'required|string|max:255|unique:empleados,dni_empleado,' . $id,
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'nullable|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'id_puesto' => 'required|exists:puestos,id',
                'estado' => 'required|boolean',
                'direccion' => 'required|string|max:255',
                'email' => 'required|email|unique:empleados,email,' . $id,
                'telefono' => 'required|string|max:20',
                'fecha_nacimiento' => 'required|date',
                'fecha_ingreso' => 'required|date',
                'rtn' => 'required|string|max:50',
                'id_user' => 'required|exists:users,id',
            ]);

            // Asignar el usuario autenticado al campo updated_by si corresponde
            // Esto supone que estás usando autenticación
            $validatedData['updated_by'] = auth()->id();

            // Actualizar el empleado con los datos validados
            $empleado->update($validatedData);

            // Retornar el empleado actualizado
            return response()->json($empleado, 200);
        } else {
            // Retornar un mensaje de error si el empleado no existe
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
    }


    // Método para eliminar un empleado por su ID

    public function delete($id)
    {
        // Buscar el empleado por su ID
        $empleado = Empleado::find($id);

        // Verificar si el empleado existe
        if ($empleado) {
            // Eliminar el empleado
            $empleado->delete();

            // Retornar un mensaje de éxito
            return response()->json(['message' => 'Empleado eliminado correctamente'], 200);
        } else {
            // Retornar un mensaje de error si el empleado no existe
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
    }


}
