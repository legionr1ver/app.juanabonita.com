<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaniaController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ArticuloTipoController;
use App\Http\Controllers\ArticuloColorController;
use App\Http\Controllers\ArticuloTalleController;
use App\Http\Controllers\PedidoController;

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

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/user',function (Request $request) {
        $user = $request->user();
        return [
            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'cliente' => $user->cliente,
        ];
    });

    Route::get('/campania/{id}', [CampaniaController::class, 'index']);
    Route::get('/campanias-habilitadas', [CampaniaController::class, 'habilitadas']);

    Route::get('/articulo', [ArticuloController::class, 'index']);
    Route::get('/tipo', [ArticuloTipoController::class, 'index']);
    Route::get('/color', [ArticuloColorController::class, 'index']);
    Route::get('/talle', [ArticuloTalleController::class, 'index']);

    Route::post('/pedido', [PedidoController::class, 'store']);
});