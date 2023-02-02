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

//Ordenes Alojamiento
Route::group(['prefix'=>'alojamiento'],function() {
    // * /api/alojamiento/
    Route::get('', [AlojamientosController::class, 'tots']);
    // * /api/alojamiento/1
    Route::get('/{id}', [AlojamientosController::class, 'show']);
    // * /api/alojamiento/borra/1
    Route::delete('/borra/{id}', [AlojamientosController::class, 'borra'])->middleware('checktoken');
    // * /api/alojamiento/crea
    Route::post('/crea', [AlojamientosController::class, 'crea'])->middleware('checktoken');
    // * /api/alojamiento/modifica/1
    Route::put('/modifica/{id}', [AlojamientosController::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Usuario
Route::group(['prefix'=>'usuario'],function (){
    // * /api/usuario/
    Route::get('', [\App\Http\Controllers\UsuarioControler::class, 'tots'])->middleware('checktoken');
    // * /api/usuario/1
    Route::get('/{id}', [\App\Http\Controllers\UsuarioControler::class, 'show'])->middleware('checktoken');
    // * /api/usuario/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\UsuarioControler::class, 'borra'])->middleware('checktoken');
    // * /api/usuario/crea
    Route::post('/crea', [\App\Http\Controllers\UsuarioControler::class, 'crea'])->middleware('checktoken');
    // * /api/usuario/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\UsuarioControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Categorias
Route::group(['prefix'=>'categoria'],function() {
    // * /api/categoria/
    Route::get('', [\App\Http\Controllers\CategoriaControler::class, 'tots'])->middleware('checktoken');
    // * /api/categoria/1
    Route::get('/{id}', [\App\Http\Controllers\CategoriaControler::class, 'show'])->middleware('checktoken');
    // * /api/categoria/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\CategoriaControler::class, 'borra'])->middleware('checktoken');
    // * /api/categoria/crea
    Route::post('/crea', [\App\Http\Controllers\CategoriaControler::class, 'crea'])->middleware('checktoken');
    // * /api/categoria/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\CategoriaControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Descripcion
Route::group(['prefix'=>'descripcion'],function() {
    // * /api/descripcion/
    Route::get('', [\App\Http\Controllers\DescripcionControler::class, 'tots'])->middleware('checktoken');
    // * /api/descripcion/1
    Route::get('/{id}', [\App\Http\Controllers\DescripcionControler::class, 'show'])->middleware('checktoken');
    // * /api/descripcion/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\DescripcionControler::class, 'borra'])->middleware('checktoken');
    // * /api/descripcion/crea
    Route::post('/crea', [\App\Http\Controllers\DescripcionControler::class, 'crea'])->middleware('checktoken');
    // * /api/descripcion/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\DescripcionControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Fotografia
Route::group(['prefix'=>'fotografia'],function() {
    // * /api/fotografia/
    Route::get('', [\App\Http\Controllers\FotografiaControler::class, 'tots'])->middleware('checktoken');
    // * /api/fotografia/1
    Route::get('/{id}', [\App\Http\Controllers\FotografiaControler::class, 'show'])->middleware('checktoken');
    // * /api/fotografia/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\FotografiaControler::class, 'borra'])->middleware('checktoken');
    // * /api/fotografia/crea
    Route::post('/crea', [\App\Http\Controllers\FotografiaControler::class, 'crea'])->middleware('checktoken');
    // * /api/fotografia/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\FotografiaControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Idioma
Route::group(['prefix'=>'idioma'],function() {
    // * /api/idioma/
    Route::get('', [\App\Http\Controllers\IdiomaControler::class, 'tots'])->middleware('checktoken');
    // * /api/idioma/1
    Route::get('/{id}', [\App\Http\Controllers\IdiomaControler::class, 'show'])->middleware('checktoken');
    // * /api/idioma/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\IdiomaControler::class, 'borra'])->middleware('checktoken');
    // * /api/idioma/crea
    Route::post('/crea', [\App\Http\Controllers\IdiomaControler::class, 'crea'])->middleware('checktoken');
    // * /api/idioma/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\IdiomaControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Municipio
Route::group(['prefix'=>'municipio'],function() {
    // * /api/municipio/
    Route::get('', [\App\Http\Controllers\MunicipioControler::class, 'tots'])->middleware('checktoken');
    // * /api/municipio/1
    Route::get('/{id}', [\App\Http\Controllers\MunicipioControler::class, 'show'])->middleware('checktoken');
    // * /api/municipio/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\MunicipioControler::class, 'borra'])->middleware('checktoken');
    // * /api/municipio/crea
    Route::post('/crea', [\App\Http\Controllers\MunicipioControler::class, 'crea'])->middleware('checktoken');
    // * /api/municipio/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\MunicipioControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Servicio
Route::group(['prefix'=>'servicio'],function() {
    // * /api/servicio/
    Route::get('', [\App\Http\Controllers\ServicioControler::class, 'tots'])->middleware('checktoken');
    // * /api/servicio/1
    Route::get('/{id}', [\App\Http\Controllers\ServicioControler::class, 'show'])->middleware('checktoken');
    // * /api/servicio/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\ServicioControler::class, 'borra'])->middleware('checktoken');
    // * /api/servicio/crea
    Route::post('/crea', [\App\Http\Controllers\ServicioControler::class, 'crea'])->middleware('checktoken');
    // * /api/servicio/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\ServicioControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes TipoAlojamiento
Route::group(['prefix'=>'tipoalojamiento'],function() {
    // * /api/tipoalojamiento/
    Route::get('', [\App\Http\Controllers\TipoAlojameintoControler::class, 'tots'])->middleware('checktoken');
    // * /api/tipoalojamiento/1
    Route::get('/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'show'])->middleware('checktoken');
    // * /api/tipoalojamiento/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'borra'])->middleware('checktoken');
    // * /api/tipoalojamiento/crea
    Route::post('/crea', [\App\Http\Controllers\TipoAlojameintoControler::class, 'crea'])->middleware('checktoken');
    // * /api/tipoalojamiento/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes TipoVacacional
Route::group(['prefix'=>'tipovacacional'],function() {
    // * /api/tipovacacional/
    Route::get('', [\App\Http\Controllers\TipovacacionalControler::class, 'tots'])->middleware('checktoken');
    // * /api/tipovacacional/1
    Route::get('/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'show'])->middleware('checktoken');
    // * /api/tipovacacional/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'borra'])->middleware('checktoken');
    // * /api/tipovacacional/crea
    Route::post('/crea', [\App\Http\Controllers\TipovacacionalControler::class, 'crea'])->middleware('checktoken');
    // * /api/tipovacacional/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Valoracion
Route::group(['prefix'=>'valoracion'],function() {
    // * /api/valoracion/
    Route::get('', [\App\Http\Controllers\ValoracionControler::class, 'tots'])->middleware('checktoken');
    // * /api/valoracion/usuari/{idusuari}/allotjament/{idallotjament}
    Route::get('/usuari/{idusuari}/allotjament/{idallotjament}', [\App\Http\Controllers\ValoracionControler::class, 'show'])->middleware('checktoken');
    // * /api/valoracion/borra/usuari/{idusuari}/allotjament/{idallotjament}
    Route::delete('/borra/usuari/{idusuari}/allotjament/{idallotjament}', [\App\Http\Controllers\ValoracionControler::class, 'borra'])->middleware('checktoken');
    // * /api/valoracion/crea
    Route::post('/crea', [\App\Http\Controllers\ValoracionControler::class, 'crea'])->middleware('checktoken');
    // * /api/valoracion/modifica/usuari/{idusuari}/allotjament/{idallotjament}
    Route::put('/modifica/usuari/{idusuari}/allotjament/{idallotjament}', [\App\Http\Controllers\ValoracionControler::class, 'modifica'])->middleware('checktoken');
});
//Ordenes Reserva
Route::group(['prefix'=>'reserva'],function() {
    // * /api/reserva/
    Route::get('', [\App\Http\Controllers\ReservaController::class, 'tots']);
    // * /api/reserva/1
    Route::get('/{id}', [\App\Http\Controllers\ReservaController::class, 'show']);
    // * /api/reserva/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\ReservaController::class, 'borra']);
    // * /api/reserva/crea
    Route::post('/crea', [\App\Http\Controllers\ReservaController::class, 'crea']);
    // * /api/reserva/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\ReservaController::class, 'modifica']);
});
//Ordenes Usuario
Route::group(['prefix'=>'usuario'],function() {
    // * /api/usuario/
    Route::post('/crea', [\App\Http\Controllers\UsuarioControler::class, 'crea']);
});
//Ordenes LoguIn
Route::group(['prefix'=>'Log'],function(){
    Route::post("/in",[\App\Http\Controllers\LogInController::class, 'login']);
});

