<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExportController;

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

Route::group(['prefix' => 'exportar'], function () {
    Route::get('ayudas', [ExportController::class, 'exportAyudas']);
    Route::get('mensajes', [ExportController::class, 'exportMensajes']);
    Route::get('contenidos', [ExportController::class, 'exportContenidos']);
    Route::get('etiquetas', [ExportController::class, 'exportEtiquetas']);
    Route::get('ocupaciones', [ExportController::class, 'exportOcupaciones']);
    Route::get('palabras-vetadas', [ExportController::class, 'exportPalabrasVetadas']);
    Route::get('usuarios', [ExportController::class, 'exportUsuarios']);

});

Route::get('prueba', [ExportController::class, 'prueba']);


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
