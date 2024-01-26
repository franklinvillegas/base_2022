<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

use App\Http\Controllers\PersonaController;
use App\Http\Controllers\DocumentoController;





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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login_linkendin', [AuthController::class, 'loginLinkedin']);
    Route::post('admin', [AuthController::class, 'loginAdmin']);
    Route::post('invitado', [AuthController::class, 'loginInvitado']);
});


Route::middleware('auth:api')->group(function () {

  //rutas para usuario logueado
  Route::group(['prefix' => 'auth'], function () {
    Route::post('check', [AuthController::class, 'check']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getPerfilUsuario']);

  });

  Route::group(['prefix' => 'usuario'], function () {
    Route::post('registrar_preferencias', [UsuarioController::class, 'registrarPreferencia']);
    Route::post('actualizar_avatar', [UsuarioController::class, 'actualizarAvatar']);
    Route::post('actualizar_qr', [UsuarioController::class, 'actualizarQR']);
    Route::post('actualizar_ayuda', [UsuarioController::class, 'actualizarMsgAyuda']);
    Route::get('ver/{id}', [UsuarioController::class, 'ver']);
    Route::get('llenar_combo', [UsuarioController::class, 'llenarCombo']);
    Route::post('seguir', [UsuarioController::class, 'seguirUsuario']);
    Route::get('obtener_notificaciones', [UsuarioController::class, 'obtenerNotificaciones']);
    Route::get('prueba', [UsuarioController::class, 'prueba']);
    //admin
    Route::get('listar', [UsuarioController::class, 'listar']);
    Route::post('registrar', [UsuarioController::class, 'crear']);
    Route::post('crear', [UsuarioController::class, 'crear']);
    Route::put('modificar/{id}', [UsuarioController::class, 'modificar']);
    Route::put('inactivar/{id}', [UsuarioController::class, 'inactivar']);
    Route::put('activar/{id}', [UsuarioController::class, 'activar']);
    Route::get('dashboard', [UsuarioController::class, 'dashboard']);

  });


  //Grupo Persona
  Route::group(['prefix' => 'persona'], function () {
    Route::get('ver/{id}', [PersonaController::class, 'ver']);
    Route::get('buscar/{dni}', [PersonaController::class, 'buscar']);
    Route::get('llenar_combo', [PersonaController::class, 'llenarCombo']);
    Route::get('listar', [PersonaController::class, 'listar']);
    Route::post('crear', [PersonaController::class, 'crear']);
    Route::put('modificar/{id}', [PersonaController::class, 'modificar']);
    Route::put('inactivar/{id}', [PersonaController::class, 'inactivar']);
    Route::put('activar/{id}', [PersonaController::class, 'activar']);
    Route::get('listar_basico', [PersonaController::class, 'listarBasico']);
    Route::get('listar_sugerencias', [PersonaController::class, 'listarSugerencias']);
    Route::get('listar_tendencia_rubros', [PersonaController::class, 'listarTendenciaRubros']);
    Route::get('temas_rubro', [PersonaController::class, 'listarTemasRubro']);
    Route::get('rubros_criterio', [PersonaController::class, 'listarRubrosCriterio']);
    Route::get('listar_temas', [PersonaController::class, 'listarTemasCriterio']);

  });
  //extrasss
  Route::group(['prefix' => 'documento'], function () {
    Route::get('listar', [DocumentoController::class, 'listar']);
  });

});


