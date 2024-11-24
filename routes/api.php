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
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/logout', [AuthuserController::class, 'logout']);

});

//----------------------------------------------------------------------------------------------------------------------------
// rutas de categorias

Route::get('/categoria', [CategoriasController::class, 'index']);

Route::get('/categoria/{id}', [CategoriasController::class, 'show']);

Route::post('/categoria', [CategoriasController::class, 'create']);

Route::put('/categoria/{id}', [CategoriasController::class, 'update']);


Route::delete('/categoria/{id}', [CategoriasController::class, 'delete']);

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