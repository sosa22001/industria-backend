<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\LoginUser;
use App\Livewire\RegisterUser;

Route::get('/', function () {
    return view('welcome');




});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
