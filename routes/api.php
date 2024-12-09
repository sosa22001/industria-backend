<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriasController;
use App\Http\Controllers\Api\ProveedoresController;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\PuestosController;
use App\Http\Controllers\Api\EmpleadosController;
use App\Http\Controllers\Api\VentasController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AuthuserController;
use App\Http\Controllers\FichaInventarioController;
use App\Http\Controllers\FichaProductoController;

                                                                                                                                           /*
||  ---------------------------------------------------------------------------------------------------------------||
||  ---------------------------------------------------------------------------------------------------------------||
||                                                                                                                 ||
||  ***            ***            *****     *******************    *****             ***       ***  ************** ||
||  ***            ***           *** ***    *******************   *** ***            ***      ***   ************** || 
||  ***            ***          ***   ***           ***          ***   ***           ***    ***     ***            ||
||  ***            ***         ***     ***          ***         ***     ***          ***   ***      ***            ||
||  ***            ***        ***       ***         ***        ***       ***         ***  ***       ***            ||
||  ******************       ***************        ***       ***************        *** ***        ************** ||
||  ******************      *****************       ***      *****************       ***  ***       ************** ||
||  ***            ***     ***             ***      ***     ***             ***      ***   ***      ***            ||
||  ***            ***    ***               ***     ***    ***               ***     ***    ***     ***            ||
||  ***            ***   ***                 ***    ***   ***                 ***    ***     ***    ***            ||
||  ***            ***  ***                   ***   ***  ***                   ***   ***      ***   ************** ||
||  ***            *** ***                     ***  *** ***                     ***  ***       ***  ************** ||
||                                                                                                                 ||
||-----------------------------------------------------------------------------------------------------------------||
||-----------------------------------------------------------------------------------------------------------------||
                                                                                                                                                     */

// rutas de usuarios

Route::post('/register', [AuthuserController::class, 'register']);

Route::post('/login', [AuthuserController::class, 'login']);

Route::get('/register', [AuthuserController::class, 'index']);

Route::get('/register/{id}', [AuthuserController::class, 'show']);


// rutas de autenticacion
//----------------------------------------------------------------------------------------------------------------------------

Route::post('/usuarios/{id}/asignar-rol', [AuthuserController::class, 'asignarRol']);
// rutas de categorias

Route::middleware(['auth:sanctum'])->group(function () {

    // Rutas accesibles solo por usuarios con el rol 'Admin'
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/categoria', [CategoriasController::class, 'index']);
        Route::post('/categoria', [CategoriasController::class, 'create']);
        Route::put('/categoria/{id}', [CategoriasController::class, 'update']);
        Route::delete('/categoria/{id}', [CategoriasController::class, 'delete']);

     
    });

    Route::get('/logout', [AuthuserController::class, 'logout']);
    //

});
//----------------------------------------------------------------------------------------------------------------------------
// rutas de proveedores
Route::get('/proveedores', [ProveedoresController::class, 'index']);

Route::get('/proveedores/{id}', [ProveedoresController::class, 'show']);

Route::post('/proveedores', [ProveedoresController::class, 'create']);

Route::put('/proveedores/{id}', [ProveedoresController::class, 'update']);

Route::delete('/proveedores/{id}', [ProveedoresController::class, 'delete']);

//----------------------------------------------------------------------------------------------------------------------------
// rutas de productos

Route::get('/productos', [ProductosController::class, 'index']);

Route::get('/productos/{id}', [ProductosController::class, 'show']);

Route::post('/productos', [ProductosController::class, 'create']);

Route::put('/productos/{id}', [ProductosController::class, 'update']);

Route::delete('/productos/{id}', [ProductosController::class, 'delete']);

//obtener productos por proveedor.
Route::get('/productos/proveedor/{idProveedor}', [ProductosController::class,'buscarProductosPorProveedor']);

//----------------------------------------------------------------------------------------------------------------------------
// Rutas de Puestos

Route::get('/puestos', [PuestosController::class, 'index']);

Route::get('/puestos/{id}', [PuestosController::class, 'show']);

Route::post('/puestos', [PuestosController::class, 'create']);

Route::put('/puestos/{id}', [PuestosController::class, 'update']);

Route::delete('/puestos/{id}', [PuestosController::class, 'destroy']);



//----------------------------------------------------------------------------------------------------------------------------
// Rutas de Empleados

Route::get('/empleados', [EmpleadosController::class, 'index']);

Route::get('/empleados/{id}', [EmpleadosController::class, 'show']);

Route::post('/empleados', [EmpleadosController::class, 'create']);

Route::put('/empleados/{id}', [EmpleadosController::class, 'update']);

Route::delete('/empleados/{id}', [EmpleadosController::class, 'delete']);

//----------------------------------------------------------------------------------------------------------------------------
// Rutas de Ventas

Route::get('/ventas', [VentasController::class, 'index']);

Route::post('/ventas', [VentasController::class, 'store']);

//Rutas de Ficha de inventario:

Route::get('/fichas-inventario', [FichaInventarioController::class, 'index']);
Route::post('/fichas-inventario', [FichaInventarioController::class, 'store']);
Route::get('/fichas-inventario/{id}', [FichaInventarioController::class, 'show']);
Route::put('/fichas-inventario/{id}', [FichaInventarioController::class, 'update']);
Route::delete('/fichas-inventario/{id}', [FichaInventarioController::class, 'destroy']);

// Ruta para obtener las fichas de inventario pendientes
Route::get('/fichas-pendientes-de-inventario', [FichaInventarioController::class, 'pendientes']);

Route::put('/fichaInventario/{id}/verificar-pedido', [FichaInventarioController::class, 'verificarFicha']);

//NO LA VOY A USAR.
//Route::put('/ficha-inventario-recibido/{id}', [FichaInventarioController::class, 'verificarARecibido']);

Route::put('/ficha-inventario-procesado/{id}', [FichaInventarioController::class, 'cambiarAProcesado']);
Route::put('/ficha-inventario-procesar-devolucion/{id}', [FichaInventarioController::class, 'devolverProducto']);


//Rutas de ficha de produto:
Route::get('/ficha-producto', [FichaProductoController::class, 'index']);
Route::post('/ficha-producto', [FichaProductoController::class, 'store']);
Route::get('/ficha-producto/{id}', [FichaProductoController::class, 'show']);
Route::get('/ficha-producto-inventario/{id_inventario}', [FichaProductoController::class, 'obtenerFichasPorIDInventario']);

//OCUPO TRAER LOS PRODUCTOS DE LAS FICHAS DE PRODUCTO POR LOTE, PARA DEVOLVERLOS.
Route::get('/fichas-producto-procesadas/{idProveedor}/para-devolver', [FichaProductoController::class,'obtenerFichasProductosProcesadas']);