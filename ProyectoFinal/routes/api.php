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

Route::group(['prefix'=>'alojamiento'],function() {
    // * /api/alojamiento/
    Route::get('', [AlojamientosController::class, 'tots']);
    // * /api/alojamiento/1
    Route::get('/{id}', [AlojamientosController::class, 'show']);
    // * /api/alojamiento/borra/1
    Route::delete('/borra/{id}', [AlojamientosController::class, 'borra']);
    // * /api/alojamiento/crea
    Route::post('/crea', [AlojamientosController::class, 'crea']);
});
Route::get('/alojamiento', [\App\Http\Controllers\AlojamientosController::class, 'tots'])-> name("alojamiento1");

Route::get('/alojamiento/{id}', [\App\Http\Controllers\AlojamientosController::class, 'show'])-> name("alojamiento2");
