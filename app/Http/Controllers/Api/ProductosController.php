<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Método para obtener todos los productos

    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::all();

        // Verificar si la colección está vacía
        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos registrados'], 404);
        }

        // Retornar la lista de productos
        return response()->json($productos, 200);
    }


    // Método para crear un nuevo producto

    public function create(Request $request) 
     {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'codigo' => 'required|string|unique:productos,codigo|max:255',
            'descripcion' => 'nullable|string',
            'id_proveedor' => 'required|exists:proveedores,id',
        ]);

        // Crear el producto
        $producto = Producto::create($validatedData);

        // Verificar si el producto fue creado exitosamente
        if ($producto) {
            // Retornar la respuesta con el producto creado y código 201
            return response()->json($producto, 201);
        } else {
            // Retornar un mensaje de error si la creación falla
            return response()->json([
                'message' => 'No se pudo crear el producto. Inténtalo de nuevo más tarde.'
            ], 500); // Código 500 para error interno del servidor
        }
    }

    // Método para obtener un producto por su ID    
    public function show($id)
    {
        // Buscar un producto por su ID
        $producto = Producto::find($id);

        // Verificar si el producto existe
        if ($producto) {
            // Retornar el producto encontrado
            return response()->json($producto, 200);
        } else {
            // Retornar un mensaje de error si el producto no se encuentra
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }

    // Método para actualizar un producto por su ID

    public function update(Request $request, $id)
    {
        // Buscar el producto por su ID
        $producto = Producto::find($id);

        // Verificar si el producto existe
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'codigo' => 'required|string|unique:productos,codigo,' . $id . ',id',
            'descripcion' => 'nullable|string',
            'id_proveedor' => 'required|exists:proveedores,id',
        ]);

        // Actualizar el producto con los datos validados
        $producto->update($validatedData);

        // Retornar el producto actualizado
        return response()->json($producto, 200);
    }

    // Método para eliminar un producto por su ID

    public function delete($id)
    {
        // Buscar el producto por su ID
        $producto = Producto::find($id);

        // Verificar si el producto existe
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Eliminar el producto
        $producto->delete();

        // Retornar un mensaje de éxito
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
