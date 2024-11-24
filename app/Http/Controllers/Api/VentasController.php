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
                'id_empleado' => 'required|exists:empleados,id',
            ]);
            \Log::info('Datos validados correctamente');

            // Crear la venta principal
            \Log::info('Creando venta principal...');
            $venta = Venta::create([
                'subtotal' => $request->subtotal,
                'isv' => $request->isv,
                'descuento' => $request->descuento,
                'total' => $request->total,
                'id_empleado' => $request->id_empleado,
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
}
