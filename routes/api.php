<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaniaController;
use App\Http\Controllers\ArticuloController;

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
        return $request->user();
    });

    Route::get('/campania/{id}', [CampaniaController::class, 'index']);
    Route::get('/campanias-habilitadas', [CampaniaController::class, 'habilitadas']);

    Route::get('/articulo', [ArticuloController::class, 'index']);
});