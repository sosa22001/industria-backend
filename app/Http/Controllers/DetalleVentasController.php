<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class DetalleVentasController extends Controller
{
    public function index()
    {
        $detallesVentas = DetalleVenta::with('producto')->get(); // Cargar la relación 'producto'

        return response()->json($detallesVentas);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function topProductos()
    {
        // Obtener los 3 productos más vendidos
        $productos = DetalleVenta::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->groupBy('producto_id')
            ->orderByDesc('total_vendido')
            ->limit(3)
            ->with('producto') // Eager load producto
            ->get();

        return response()->json($productos);
    }
}
