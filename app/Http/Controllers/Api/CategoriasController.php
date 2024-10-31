<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function esdras()
    {
    $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            return response()->json(['message' => 'No hay categorias registradas'], 404);
        }
        
        

         return response()->json($categorias, 200);
    }

    public function create(Request $request)
    {
    // Validar que 'nombre_categoria' es requerido y no vacío
    $request->validate([
        'nombre_categoria' => 'required|string|max:255'
    ]);

    // Intentar crear una nueva categoría usando el modelo
    $categoria = Categoria::create([
        'nombre_categoria' => $request->nombre_categoria,
        
    ]);

    // Verificar si la categoría fue creada exitosamente
    if ($categoria) {
        // Retornar respuesta JSON con la categoría creada y código 201
            return response()->json($categoria, 201);
        } else {
            // Retornar un mensaje de error si la creación falla
            return response()->json([
                'message' => 'No se pudo crear la categoría. Inténtalo de nuevo más tarde.'
            ], 500); // Código 500 para error interno del servidor
        }
    }



    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            $data =[
                'message' => 'No se encontró la categoría con el ID proporcionado', 
                'status' => 404
            ];
            return response()->json($data, 404);
         }

        $data = [
            'categoria' => $categoria,
            'status' => 200
        ];

        return response()->json($data, 200);


    }

    public function delete($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            $data = [
                'message' => 'No se encontró la categoría con el ID proporcionado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $categoria->delete();

        $data = [
            'message' => 'Categoría eliminada correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            $data = [
                'message' => 'No se encontró la categoría con el ID proporcionado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'nombre_categoria' => 'required|string|max:255'
        ]);

        $categoria->nombre_categoria = $request->nombre_categoria;
        $categoria->save();

        $data = [
            'message' => 'Categoría actualizada correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    
}


