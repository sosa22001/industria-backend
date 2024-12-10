<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ProductosController extends Controller
{
    // Método para obtener todos los productos

    public function index()
    {
        // Obtener todos los productos con las relaciones de categoría y proveedor
        $productos = Producto::with(['categoria', 'proveedor'])->get();

        // Verificar si la colección está vacía
        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No hay productos registrados'], 404);
        }

        // Mapear la respuesta para incluir los nombres de categoría y proveedor
        $productosConDetalles = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre_producto' => $producto->nombre_producto,
                'stock' => $producto->stock,
                'categoria' => $producto->categoria ? $producto->categoria->nombre_categoria : 'No asignado', // Nombre de la categoría
                'proveedor' => $producto->proveedor ? $producto->proveedor->nombre_proveedor : 'No asignado', // Nombre del proveedor
                'precio_compra' => $producto->precio_compra,
                'precio_venta' => $producto->precio_venta,
                'estado' => $producto->estado,
                'codigo' => $producto->codigo,
                'descripcion' => $producto->descripcion,
                'crated_at' => $producto->created_at,
                'updated_at' => $producto->updated_at,
                'deleted_at' => $producto->deleted_at,
            ];
        });

        // Retornar los productos con los detalles de categoría y proveedor
        return response()->json($productosConDetalles, 200);
    }






    //-------------------------------------------------------------------------------------------   

    // Método para crear un nuevo producto

    public function create(Request $request)
    {
        try {
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

            // Crear el producto usando el modelo Producto
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
        } catch (ValidationException $e) {
            // Si la validación falla, retornar los errores de validación
            return response()->json([
                'errors' => $e->errors()
            ], 422); // Código 422 para error de validación
        } catch (\Exception $e) {
            // En caso de cualquier otro error, retornar un mensaje genérico
            return response()->json([
                'message' => 'No se pudo crear el producto. Inténtalo de nuevo más tarde.'
            ], 500); // Código 500 para error interno del servidor
        }
    }

    // Método para obtener un producto por su ID    
    public function show($search)
    {
        // Buscar el producto por ID, nombre_producto o código
        $producto = Producto::where('id', $search)
            ->orWhere('nombre_producto', 'like', "%$search%")
            ->orWhere('codigo', 'like', "%$search%")
            ->first();

        // Verificar si el producto existe
        if ($producto) {
            // Retornar el producto encontrado
            return response()->json([
                'status' => 'success',
                'data' => $producto,
            ], 200);
        } else {
            // Retornar un mensaje de error si el producto no se encuentra
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado',
            ], 404);
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

    //Método para traer productos por id de proveedor.
    public function buscarProductosPorProveedor($idProveedor)
    {
        // Obtener productos por el ID del proveedor
        $productos = Producto::where('id_proveedor', $idProveedor)->get();

        // Verificar si se encontraron productos
        if ($productos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos para este proveedor'], 404);
        }

        return response()->json($productos, 200);
    }

    public function cantidadDeProductosPorCategoria()
    {
        try {
            $productosPorCategoria = Categoria::withCount('productos')->get();

            $data = $productosPorCategoria->map(function ($categoria) {
                return [
                    'categoria' => $categoria->nombre_categoria, // Cambia 'nombre' por el campo de tu tabla categorías
                    'cantidad' => $categoria->productos_count,
                ];
            });

            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
