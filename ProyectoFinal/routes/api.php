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
    Route::delete('/borra/{id}', [AlojamientosController::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/alojamiento/crea
    Route::post('/crea', [AlojamientosController::class, 'crea'])->middleware('checkTokenUser');
    // * /api/alojamiento/modifica/1
    Route::put('/modifica/{id}', [AlojamientosController::class, 'modifica'])->middleware('checkTokenAdmin');
});

//Ordenes Usuario
Route::group(['prefix'=>'usuario'],function (){
    // * /api/usuario/
    Route::get('', [\App\Http\Controllers\UsuarioControler::class, 'tots'])->middleware('checkTokenAdmin');
    // * /api/usuario/1
    Route::get('/{id}', [\App\Http\Controllers\UsuarioControler::class, 'show'])->middleware('checkTokenAdmin');
    // * /api/usuario/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\UsuarioControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/usuario/crea
    Route::post('/crea', [\App\Http\Controllers\UsuarioControler::class, 'crea']);
    // * /api/usuario/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\UsuarioControler::class, 'modifica'])->middleware('checkTokenAdmin');
});

//Ordenes Categorias
Route::group(['prefix'=>'categoria'],function() {
    // * /api/categoria/
    Route::get('', [\App\Http\Controllers\CategoriaControler::class, 'tots']);
    // * /api/categoria/1
    Route::get('/{id}', [\App\Http\Controllers\CategoriaControler::class, 'show']);
    // * /api/categoria/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\CategoriaControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/categoria/crea
    Route::post('/crea', [\App\Http\Controllers\CategoriaControler::class, 'crea'])->middleware('checkTokenAdmin');
    // * /api/categoria/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\CategoriaControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Descripcion
Route::group(['prefix'=>'descripcion'],function() {
    // * /api/descripcion/
    Route::get('', [\App\Http\Controllers\DescripcionControler::class, 'tots']);
    // * /api/descripcion/1
    Route::get('/{id}', [\App\Http\Controllers\DescripcionControler::class, 'show']);
    // * /api/descripcion/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\DescripcionControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/descripcion/crea
    Route::post('/crea', [\App\Http\Controllers\DescripcionControler::class, 'crea'])->middleware('checkTokenUser');
    // * /api/descripcion/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\DescripcionControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Fotografia
Route::group(['prefix'=>'fotografia'],function() {
    // * /api/fotografia/
    Route::get('', [\App\Http\Controllers\FotografiaControler::class, 'tots']);
    // * /api/fotografia/1
    Route::get('/{id}', [\App\Http\Controllers\FotografiaControler::class, 'show']);
    // * /api/fotografia/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\FotografiaControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/fotografia/crea
    Route::post('/crea', [\App\Http\Controllers\FotografiaControler::class, 'crea'])->middleware('checkTokenUser');
    // * /api/fotografia/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\FotografiaControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Idioma
Route::group(['prefix'=>'idioma'],function() {
    // * /api/idioma/
    Route::get('', [\App\Http\Controllers\IdiomaControler::class, 'tots']);
    // * /api/idioma/1
    Route::get('/{id}', [\App\Http\Controllers\IdiomaControler::class, 'show']);
    // * /api/idioma/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\IdiomaControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/idioma/crea
    Route::post('/crea', [\App\Http\Controllers\IdiomaControler::class, 'crea'])->middleware('checkTokenAdmin');
    // * /api/idioma/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\IdiomaControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Municipio
Route::group(['prefix'=>'municipio'],function() {
    // * /api/municipio/
    Route::get('', [\App\Http\Controllers\MunicipioControler::class, 'tots']);
    // * /api/municipio/1
    Route::get('/{id}', [\App\Http\Controllers\MunicipioControler::class, 'show']);
    // * /api/municipio/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\MunicipioControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/municipio/crea
    Route::post('/crea', [\App\Http\Controllers\MunicipioControler::class, 'crea'])->middleware('checkTokenAdmin');
    // * /api/municipio/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\MunicipioControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Servicio
Route::group(['prefix'=>'servicio'],function() {
    // * /api/servicio/
    Route::get('', [\App\Http\Controllers\ServicioControler::class, 'tots']);
    // * /api/servicio/1
    Route::get('/{id}', [\App\Http\Controllers\ServicioControler::class, 'show']);
    // * /api/servicio/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\ServicioControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/servicio/crea
    Route::post('/crea', [\App\Http\Controllers\ServicioControler::class, 'crea'])->middleware('checkTokenUser');
    // * /api/servicio/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\ServicioControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes TipoAlojamiento
Route::group(['prefix'=>'tipoalojamiento'],function() {
    // * /api/tipoalojamiento/
    Route::get('', [\App\Http\Controllers\TipoAlojameintoControler::class, 'tots']);
    // * /api/tipoalojamiento/1
    Route::get('/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'show']);
    // * /api/tipoalojamiento/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/tipoalojamiento/crea
    Route::post('/crea', [\App\Http\Controllers\TipoAlojameintoControler::class, 'crea'])->middleware('checkTokenAdmin');
    // * /api/tipoalojamiento/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\TipoAlojameintoControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes TipoVacacional
Route::group(['prefix'=>'tipovacacional'],function() {
    // * /api/tipovacacional/
    Route::get('', [\App\Http\Controllers\TipovacacionalControler::class, 'tots']);
    // * /api/tipovacacional/1
    Route::get('/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'show']);
    // * /api/tipovacacional/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/tipovacacional/crea
    Route::post('/crea', [\App\Http\Controllers\TipovacacionalControler::class, 'crea'])->middleware('checkTokenAdmin');
    // * /api/tipovacacional/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\TipovacacionalControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Valoracion
Route::group(['prefix'=>'valoracion'],function() {
    // * /api/valoracion/
    Route::get('', [\App\Http\Controllers\ValoracionControler::class, 'tots']);
    // * /api/valoracion/usuari/{idusuari}/allotjament/{idallotjament}
    Route::get('/usuario/{usuarioId}/alojamiento/{AlojamientoId}', [\App\Http\Controllers\ValoracionControler::class, 'show']);
    // * /api/valoracion/borra/usuari/{idusuari}/allotjament/{idallotjament}
    Route::delete('/borra/usuario/{usuarioId}/alojamiento/{AlojamientoId}', [\App\Http\Controllers\ValoracionControler::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/valoracion/crea
    Route::post('/crea', [\App\Http\Controllers\ValoracionControler::class, 'crea'])->middleware('checkTokenUser');
    // * /api/valoracion/modifica/usuari/{idusuari}/allotjament/{idallotjament}
    Route::put('/modifica/usuario/{usuarioId}/alojamiento/{AlojamientoId}', [\App\Http\Controllers\ValoracionControler::class, 'modifica'])->middleware('checkTokenAdmin');
});
//Ordenes Reserva
Route::group(['prefix'=>'reserva'],function() {
    // * /api/reserva/
    Route::get('', [\App\Http\Controllers\ReservaController::class, 'tots']);
    // * /api/reserva/1
    Route::get('/{id}', [\App\Http\Controllers\ReservaController::class, 'show']);
    // * /api/reserva/borra/1
    Route::delete('/borra/{id}', [\App\Http\Controllers\ReservaController::class, 'borra'])->middleware('checkTokenAdmin');
    // * /api/reserva/crea
    Route::post('/crea', [\App\Http\Controllers\ReservaController::class, 'crea'])->middleware('checkTokenUser');
    // * /api/reserva/modifica/1
    Route::put('/modifica/{id}', [\App\Http\Controllers\ReservaController::class, 'modifica'])->middleware('checkTokenAdmin');
});

//Ordenes LogIn/LogOut
Route::group(['prefix'=>'Log'],function(){
    Route::post("/in",[\App\Http\Controllers\LogInController::class, 'login']);
    Route::post("/out",[\App\Http\Controllers\LogOutController::class, 'logout'])->middleware('checkTokenUser');
});

