<?php

namespace App\Http\Controllers;

use App\Models\FichaProducto;
use App\Models\Producto;
use App\Models\FichaInventario;
use Illuminate\Http\Request;

class FichaProductoController extends Controller
{
    /**
     * Display a listing of the FichaProducto.
     */
    public function index()
    {
        // Obtener todos los productos en fichas de inventario
        $fichas_productos = FichaProducto::with(['producto', 'fichaInventario'])->get();

        return response()->json($fichas_productos);
    }

    /**
     * Store a newly created FichaProducto.
     */
    public function store(Request $request)
    {
        // Validar la entrada
        $validated = $request->validate([
            'ficha_inventario_id' => 'required|exists:fichas_inventario,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_compra' => 'required|numeric|min:0',
            'productos.*.lote' => 'required|string|max:255',
        ]);

        $ficha_inventario_id = $validated['ficha_inventario_id'];
        $productos = $validated['productos'];

        $fichas_productos = [];

        // Crear cada ficha de producto
        foreach ($productos as $producto) {
            $fichas_productos[] = FichaProducto::create([
                'ficha_inventario_id' => $ficha_inventario_id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_compra' => $producto['precio_compra'],
                'lote' => $producto['lote'],
            ]);
        }

        return response()->json([
            'message' => 'Fichas de producto creadas exitosamente.',
            'fichas_productos' => $fichas_productos
        ], 201);
    }


    /**
     * Display the specified FichaProducto.
     */
    public function show($id)
    {
        // Mostrar los detalles de una ficha de producto específica
        $ficha_producto = FichaProducto::with(['producto', 'fichaInventario'])->find($id);

        if (!$ficha_producto) {
            return response()->json(['message' => 'Ficha de producto no encontrada'], 404);
        }

        return response()->json($ficha_producto);
    }

    public function obtenerFichasPorIDInventario($id_inventario, Request $request)
    {
        try {
            // Incluimos la relación con el producto
            $fichas_productos = FichaProducto::with('producto') // Relación definida en el modelo
                ->where('ficha_inventario_id', $id_inventario)
                ->get();

            if ($fichas_productos->count() > 0) {
                return response()->json([
                    'message' => 'Fichas de productos encontradas',
                    'data' => $fichas_productos,
                    'codigoResultado' => 1
                ]);
            }

            return response()->json([
                'message' => 'No hay fichas de productos para esta ficha de inventario',
                'codigoResultado' => 0
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }


    //QUIERO OBTENER LAS FICHAS DE PRODUCTOS
    //CUYA FICHA DE INVENTARIO YA FUE PROCESADA.
    //PARA PROCEDER A DEVOLVERLA.
    public function obtenerFichasProductosProcesadas($idProveedor, Request $request)
    {
        try {
            // Obtener las fichas de inventario cuyo estado es PROCESADO
            $fichas_inventario = FichaInventario::where('estado', 'procesado')
                ->where('proveedor_id', $idProveedor) // Filtrar por el proveedor
                ->get();

            // Verificar si no hay fichas procesadas
            if ($fichas_inventario->count() == 0) {
                return response()->json([
                    'message' => 'No hay fichas de inventario procesadas',
                    'codigoResultado' => 0
                ]);
            }

            // Obtener los ids de las fichas de inventario procesadas
            $fichas_inventario_ids = $fichas_inventario->pluck('id');

            // Buscar las fichas de productos asociadas a esas fichas de inventario
            // e incluir el producto relacionado
            $fichas_productos = FichaProducto::with('producto') // Incluir relación producto
                ->whereIn('ficha_inventario_id', $fichas_inventario_ids)
                ->where('devuelto', 0) // Agregar el filtro adicional
                ->get();

            // Si no se encuentran productos asociados
            if ($fichas_productos->count() == 0) {
                return response()->json([
                    'message' => 'No hay productos asociados a las fichas de inventario procesadas',
                    'codigoResultado' => 0
                ]);
            }

            // Ahora tienes las fichas de productos. Puedes devolver la información
            return response()->json([
                'fichas_productos' => $fichas_productos,
                'codigoResultado' => 1
            ]);
        } catch (\Throwable $th) {
            // Manejo de errores
            return response()->json([
                'message' => $th->getMessage(),
                'codigoResultado' => 0
            ]);
        }
    }
}
