<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriasController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AuthuserController;



// rutas de usuarios

Route::post('/register', [AuthuserController::class, 'register']);

Route::post('/login', [AuthuserController::class, 'login']);


// rutas de categorias

Route::get('/categoria', [CategoriasController::class, 'esdras']);

Route::get('/categoria/{id}', [CategoriasController::class, 'show']);

Route::post('/categoria', [CategoriasController::class, 'create']);

Route::put('/categoria/{id}', [CategoriasController::class, 'update']);


Route::delete('/categoria/{id}', [CategoriasController::class, 'delete']);

