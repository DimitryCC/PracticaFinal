<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hola/{nom}', function ($nom='Tu') {
    //return view('welcome');
    return "<h1>Hola $nom</h1>";
})->name("salutacio");
/*
Route::get('/alojamiento', [\App\Http\Controllers\AlojamientosController::class, 'tots'])-> name("alojamiento1");

Route::get('/alojamiento/{id}', [\App\Http\Controllers\AlojamientosController::class, 'show'])-> name("alojamiento2");
*/


