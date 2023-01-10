<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlojamientosController;

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

//Ordenes alojamiento
Route::group(['prefix'=>'alojamiento'],function() {
    // * /api/alojamiento/
    Route::get('', [AlojamientosController::class, 'tots']);
    // * /api/alojamiento/1
    Route::get('/{id}', [AlojamientosController::class, 'show']);
    // * /api/alojamiento/borra/1
    Route::delete('/borra/{id}', [AlojamientosController::class, 'borra']);
    // * /api/alojamiento/crea
    Route::post('/crea', [AlojamientosController::class, 'crea']);
    // * /api/alojamiento/modifica/1
    Route::put('/modifica/{id}', [AlojamientosController::class, 'modifica']);
});
Route::group(['prefix'=>'usuarios'],function (){
    // * /api/usuarios/
    Route::get('',[\App\Http\Controllers\UsuarioControler::class,'tots']);
    //* /api/usuarios/1
    Route::get('/{id}',[\App\Http\Controllers\UsuarioControler::class, 'show']);
    //* /api/usuarios/admin
    Route::get('/admin',[\App\Http\Controllers\UsuarioControler::class, 'admin']);
});
