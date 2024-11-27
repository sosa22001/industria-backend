<?php

namespace App\Http\Controllers;

use App\Models\FichaInventario;
use App\Models\FichaProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class FichaInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Retorna todas las fichas de inventario
        $fichas_inventario = FichaInventario::with('proveedor')->get();

        // Devolver la respuesta con los datos
        return response()->json($fichas_inventario);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos enviados
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'tipo_movimiento' => 'required|in:pedido,compra_directa,devolucion,ajuste',
            'estado' => 'required|in:pendiente,procesado,recibido,cancelado',
            'fecha_pedido' => 'required|date',
            'fecha_recepcion' => 'nullable|date|after_or_equal:fecha_pedido',
            'comentarios' => 'nullable|string|max:255',
        ]);

        try {
            // Crear la ficha de inventario
            $ficha = FichaInventario::create([
                'proveedor_id' => $validated['proveedor_id'],
                'tipo_movimiento' => $validated['tipo_movimiento'],
                'estado' => $validated['estado'],
                'fecha_pedido' => $validated['fecha_pedido'],
                'fecha_recepcion' => $validated['fecha_recepcion'],
                'comentarios' => $validated['comentarios'],
            ]);

            // Retornar una respuesta exitosa
            return response()->json([
                'message' => 'Ficha de inventario creada exitosamente',
                'ficha' => $ficha
            ], 201);
        } catch (\Exception $e) {
            // En caso de error
            return response()->json([
                'message' => 'Error al crear la ficha de inventario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar la ficha de inventario por su ID
        $ficha = FichaInventario::with(['proveedor', 'fichaProductos'])->find($id);

        if (!$ficha) {
            return response()->json(['message' => 'Ficha no encontrada'], 404);
        }

        return response()->json($ficha);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Buscar la ficha de inventario por su ID
        $ficha = FichaInventario::find($id);

        if (!$ficha) {
            return response()->json(['message' => 'Ficha no encontrada'], 404);
        }

        // Validar los datos
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'tipo_movimiento' => 'required|in:pedido,compra_directa,devolucion,ajuste',
            'estado' => 'required|in:pendiente,procesado,recibido,cancelado',
            'fecha_pedido' => 'required|date',
            'fecha_recepcion' => 'nullable|date|after_or_equal:fecha_pedido',
            'comentarios' => 'nullable|string|max:255',
        ]);

        // Actualizar la ficha de inventario
        $ficha->update($validated);

        return response()->json([
            'message' => 'Ficha de inventario actualizada exitosamente',
            'ficha' => $ficha
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar la ficha de inventario por su ID
        $ficha = FichaInventario::find($id);

        if (!$ficha) {
            return response()->json(['message' => 'Ficha no encontrada'], 404);
        }

        // Eliminar la ficha de inventario
        $ficha->delete();

        return response()->json(['message' => 'Ficha de inventario eliminada exitosamente']);
    }

    public function pendientes()
    {
        $fichas_inventario_pendientes = FichaInventario::where('estado', 'pendientes')->get();

        if ($fichas_inventario_pendientes->isEmpty()) {
            return response()->json(['message' => 'No hay fichas de inventario pendientes']);
        }

        return response()->json($fichas_inventario_pendientes);
    }

    public function verificarFicha($id, Request $request)
    {
        try {
            // Validar que la solicitud contiene los datos correctos
            $request->validate([
                'comentarios_verificacion' => 'nullable|string|max:255',
                'productos_correctos' => 'required|boolean', // Si los productos llegaron bien
                'cantidad_correcta' => 'nullable|boolean', // Si la cantidad es correcta
                'productos_dañados' => 'nullable|boolean', // Si hubo productos dañados
            ]);

            $ficha = FichaInventario::find($id);

            if (!$ficha) {
                return response()->json([
                    'message' => 'Ficha de inventario no encontrada'
                ], 404);
            }

            if ($ficha->estado != 'pendiente') {
                return response()->json([
                    'message' => 'La ficha ya ha sido procesada o está en otro estado.'
                ], 400);
            }

            $ficha->estado = $request->estado; // Cambiar el estado a 'recibido' o 'procesado'
            $ficha->comentarios = $request->comentarios_verificacion; // Agregar comentarios de verificación
            $ficha->save();

            // Si la verificación fue positiva y todo está bien
            if ($request->productos_correctos) {
                // Si la cantidad es correcta, actualizamos la cantidad en el inventario
                if ($request->cantidad_correcta) {
                    // Aquí podríamos actualizar los productos asociados en la ficha de inventario
                    // Actualizamos el stock de los productos asociados a esta ficha
                    $fichaProducto = FichaProducto::where('ficha_inventario_id', $id)->get();
                    foreach ($fichaProducto as $producto) {
                        //usando el modelo de producto puedo cambiar el stock de un producto.
                        $producto_a_modificar = Producto::find( $producto->producto_id );
                        $producto_a_modificar->stock = $producto_a_modificar->stock + $producto->cantidad;
                        $producto_a_modificar->save();
                    }
                }
            } else {
                // Si los productos no llegaron correctamente, podemos agregar un estado diferente o registrar daños
                if ($request->productos_dañados) {
                    $ficha->estado = 'pendiente'; // Opcionalmente, podemos crear un estado 'dañado' o similar
                    $ficha->save();
                }
            }

            // Retornar la ficha de inventario actualizada
            return response()->json([
                'message' => 'Se actualizó la ficha a '. $request->estado,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage()
                ],500);
        }
    }

    public function verificarARecibido($id, Request $request){
        try {

            $request->validate([
                'productos_correctos' => 'required|boolean', // Si los productos llegaron bien
                'cantidad_correcta' => 'nullable|boolean', // Si la cantidad es correcta
                'productos_dañados' => 'nullable|boolean', // Si hubo productos dañados
            ]);

            //El id es de la ficha de inventario.
            $ficha = FichaInventario::find($id);

            if( !$request->productos_correctos){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'Los productos fueron incorrectos';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por productos incorrectos',
                    'codigoResultado' => 0
                ]);
            }

            if(!$request->cantidad_correcta){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'La cantidad de productos fue incorrecta';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por cantidad incorrecta',
                    'codigoResultado' => 0
                ]);
            }

            if($request->productos_dañados){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'Hubo productos dañados';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por productos dañados',
                    'codigoResultado' => 0
                ]);
            }

            //Ya todo estaría correcto así que procedemos a cambiar el estado de la ficha de inventario a recibido.
            $ficha->estado = 'recibido';
            $ficha->comentarios = 'Todo llegó correctamente al mercadito';
            $ficha->save();

            return response()->json([
                'message' => 'Se actualizó la ficha a recibido',
                'codigoResultado' => 1
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage()
            ]);
        }
    }

    public function cambiarAProcesado($id, Request $request){
        try {
            $request->validate([
                'productos_correctos' => 'required|boolean', // Si los productos llegaron bien
                'cantidad_correcta' => 'nullable|boolean', // Si la cantidad es correcta
                'productos_dañados' => 'nullable|boolean', // Si hubo productos dañados
            ]);

            //El id es de la ficha de inventario.
            $ficha = FichaInventario::find($id);

            if( !$request->productos_correctos){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'Los productos fueron incorrectos';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por productos incorrectos',
                    'codigoResultado' => 0
                ]);
            }

            if(!$request->cantidad_correcta){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'La cantidad de productos fue incorrecta';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por cantidad incorrecta',
                    'codigoResultado' => 0
                ]);
            }

            if($request->productos_dañados){
                $ficha->estado = 'rechazado';
                $ficha->comentarios = 'Hubo productos dañados';
                $ficha->save();

                return response()->json([
                    'message'=> 'Ficha rechazada por productos dañados',
                    'codigoResultado' => 0
                ]);
            }

            //Ya todo estaría correcto así que procedemos a cambiar el estado de la ficha de inventario a procesado.

            //Tenemos que aumentar el inventario.
            $fichas_producto = FichaProducto::where('ficha_inventario_id', $id)->get();

            if( $fichas_producto->count() > 0){
                foreach ($fichas_producto as $ficha_producto) {
                    //buscamos el producto para aumentar en el stock.
                    $producto = Producto::find($ficha_producto->producto_id);
                    $producto->stock += $ficha_producto->cantidad;
                    $producto->save();
                }
            }else{
                return response()->json([
                    'message'=> 'No hay productos en la ficha de inventario',
                    'codigoResultado' => 0
                ]);
            }

            //Cambiamos el estado de la ficha de inventario a procesado.
            $ficha->estado = 'procesado';
            $ficha->comentarios = 'Todo se ha ingresado al inventario';
            $ficha->save();

            return response()->json([
                'message' => 'Se actualizó la ficha a procesado',
                'codigoResultado' => 1
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage,
                'codigoResultado' => 0
            ]);
        }
    }

    public function devolverProducto($id, Request $request){
        try {

            $ficha_inventario = FichaInventario::find( $id );
            if( $ficha_inventario == null ){
                return response()->json([
                    'message'=> 'No existe la ficha de inventario',
                    'codigoResultado' => 0
                ]);
            }

            $fichas_producto = FichaProducto::where('ficha_inventario_id', $ficha_inventario->id)->get();

            if( $fichas_producto == null ){
                return response()->json([
                    'message'=> 'No hay productos en la ficha de inventario',
                    'codigoResultado' => 0
                ]);
            }

            foreach($fichas_producto as $ficha_producto){
                //buscamos el producto
                $producto = Producto::find( $ficha_producto->producto_id );

                if(!$producto) {
                    return response()->json([
                        'message' => 'El producto con ID ' . $ficha_producto->producto_id . ' no existe',
                        'codigoResultado' => 0
                    ]);
                }

                $producto->stock = $producto->stock - $ficha_producto->cantidad; //Así le restariamos.
                $producto->save();
            }

            $ficha_inventario->estado = 'procesado';
            $ficha_inventario->comentarios = 'Se han devuelto los productos';
            $ficha_inventario->save();

            return response()->json([
                'message' => 'Se han devuelto los productos, revise su inventario',
                'codigoResultado' => 1
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message'=> $th->getMessage(),
                'codigoResultado' => 0
            ]);
        }
    }
}
