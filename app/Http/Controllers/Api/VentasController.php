<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Producto;

class VentasController extends Controller
{
    public function store(Request $request)
    {
        // Mensaje de entrada
        \Log::info('Inicio de la solicitud para registrar venta', $request->all());

        try {
            // Validar los datos de la solicitud
            \Log::info('Validando datos de la solicitud...');
            $request->validate([
                'productos' => 'required|array',
                'productos.*.id_producto' => 'required|exists:productos,id',
                'productos.*.cantidad' => 'required|integer|min:1',
                'subtotal' => 'required|numeric|min:0',
                'isv' => 'required|numeric|min:0',
                'descuento' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'id_empleado' => 'nullable|exists:empleados,id', // Ahora opcional
            ]);
            \Log::info('Datos validados correctamente');

            // Crear la venta principal
            \Log::info('Creando venta principal...');
            $venta = Venta::create([
                'subtotal' => $request->subtotal,
                'isv' => $request->isv,
                'descuento' => $request->descuento,
                'total' => $request->total,
                'id_empleado' => $request->id_empleado, // Puede ser null
                'created_by' => auth()->id(),
            ]);
            \Log::info('Venta creada exitosamente', $venta->toArray());

            // Procesar cada producto en la venta
            \Log::info('Procesando productos...');
            foreach ($request->productos as $productoData) {
                $producto = Producto::find($productoData['id_producto']);
                \Log::info("Procesando producto ID: {$producto->id}", [
                    'stock_actual' => $producto->stock,
                    'cantidad_solicitada' => $productoData['cantidad'],
                ]);

                // Verificar que hay suficiente stock
                if ($producto->stock < $productoData['cantidad']) {
                    \Log::warning("Stock insuficiente para el producto ID: {$producto->id}");
                    return response()->json([
                        'message' => "El producto {$producto->nombre_producto} no tiene suficiente stock."
                    ], 400);
                }

                // Crear el detalle de la venta
                \Log::info('Creando detalle de venta...');
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $productoData['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $productoData['cantidad'] * $producto->precio_venta,
                ]);
                \Log::info('Detalle de venta creado para producto ID: ' . $producto->id);

                // Reducir el stock del producto
                \Log::info("Reduciendo stock para producto ID: {$producto->id}");
                $producto->stock -= $productoData['cantidad'];
                $producto->save();
                \Log::info("Stock actualizado para producto ID: {$producto->id}", [
                    'nuevo_stock' => $producto->stock,
                ]);
            }

            // Respuesta final
            \Log::info('Venta registrada exitosamente');
            return response()->json([
                'message' => 'Venta registrada exitosamente.',
                'venta' => $venta,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error durante el registro de la venta', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Ocurrió un error al registrar la venta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Método para obtener todas las ventas con los productos vendidos con su cantidad y precio unitario pero que me muestre el nombre del producto

    public function index()
    {
        // Obtener todas las ventas con los detalles de productos
        $ventas = Venta::with('detalles.producto')->get();

        // Transformar los datos para mostrar solo lo necesario
        $ventasConDetalles = $ventas->map(function ($venta) {
            return [
                'id' => $venta->id,
                'fecha_venta' => $venta->fecha_venta,
                'id_empleado' => $venta->id_empleado,
                'subtotal' => $venta->subtotal,
                'isv' => $venta->isv,
                'descuento' => $venta->descuento,
                'total' => $venta->total,
                'created_by' => $venta->created_by,
                'detalles' => $venta->detalles->map(function ($detalle) {
                    return [
                        'producto' => $detalle->producto->nombre_producto,
                        'cantidad' => $detalle->cantidad,
                        'precio_unitario' => $detalle->precio_unitario,
                        'subtotal' => $detalle->subtotal,
                    ];
                }),
            ];
        });

        // Retornar las ventas con los detalles de productos
        return response()->json($ventasConDetalles, 200);
    }
}
