<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{

    // Listar todos los proveedores
    public function create(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'estado' => 'required',
            'direccion' => 'required',
        ]);

        $proveedor = Proveedor::create([
            'nombre_proveedor' => $request->nombre_proveedor,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'estado' => $request->estado,
            'direccion' => $request->direccion,
        ]);

        if ($proveedor) {
            return response()->json($proveedor, 201);
        } else {
            return response()->json([
                'message' => 'No se pudo crear el proveedor. Inténtalo de nuevo más tarde.'
            ], 500);
        }
    }
    
}
