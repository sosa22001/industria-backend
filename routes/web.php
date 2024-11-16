<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\LoginUser;
use App\Livewire\RegisterUser;

Route::get('/', function () {
    return view('welcome');




});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/prueva', function () {
    return "Hola mundo";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
