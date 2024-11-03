<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    // Mostrar todas las ventas
    public function index()
    {
        return Venta::all();
    }
}
