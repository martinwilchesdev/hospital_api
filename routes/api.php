<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// datos del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ruta de login POST
Route::post('/login', [AuthController::class, 'login']);

// ruta de registro POST
Route::post('/register', [AuthController::class, 'register']);

// pacientes
