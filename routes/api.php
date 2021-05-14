<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PedidoController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::apiResource('cuentas', CuentaController::class)->only([
    'index', 'store', 'update', 'destroy'
]);

Route::apiResource('pedidos', PedidoController::class)->only([
    'index', 'store', 'update'
]);

Route::post('cancelarPedido/{id}', [PedidoController::class, "cancel"])->name('cancelarPedido');
