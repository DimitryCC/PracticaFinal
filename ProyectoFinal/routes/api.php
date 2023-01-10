<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Funciones de Alojamientos
Route::get('/alojamiento/tots', [\App\Http\Controllers\AlojamientosController::class, 'tots'])-> name("alojamiento1");

Route::get('/alojamiento/{id}', [\App\Http\Controllers\AlojamientosController::class, 'show'])-> name("alojamiento2");
//Funciones de Usuarios
//Funciones de Servicios
//Funciones de
