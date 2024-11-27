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
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_compra' => 'required|numeric|min:0',
            'lote' => 'required|string|max:255',
            'fecha_vencimiento' => 'required|date',
        ]);

        // Crear la ficha de producto
        $ficha_producto = FichaProducto::create([
            'ficha_inventario_id' => $validated['ficha_inventario_id'],
            'producto_id' => $validated['producto_id'],
            'cantidad' => $validated['cantidad'],
            'precio_compra' => $validated['precio_compra'],
            'lote' => $validated['lote'],
            'fecha_vencimiento' => $validated['fecha_vencimiento'],
        ]);

        return response()->json([
            'message' => 'Ficha de producto creada exitosamente.',
            'ficha_producto' => $ficha_producto
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
}
