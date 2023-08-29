<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post("loginSMS",[LoginController::class, 'loginSMS']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::post("validarSMS",[LoginController::class, 'validarSMS']);    
    Route::post("finalizarRegistro",[LoginController::class, 'finalizarRegistro']);
    Route::post("logout",[LoginController::class, 'logout']);
});

Route::group(['prefix' => 'reclutador','middleware' => ["auth:sanctum"]], function () {
    Route::get("micuenta",[LoginController::class, 'micuenta']);    
    Route::post("registrarCliente",[LoginController::class, 'registrarCliente']);
    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
