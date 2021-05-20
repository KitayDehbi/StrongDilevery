<?php

use App\Http\Controllers\ApiCmdController;
use App\Http\Controllers\AuthController;
use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Commands and Panier API 

Route::group(['Middleware'=>'auth:api', 'prefix'=>'commands'], function () {
    Route::get('notReserved/', [ApiCmdController::class, 'deliveryWaitingCmds'])->name('getWaitingCmds');
    Route::get('reserveCmd/{cmd_id}', [ApiCmdController::class, 'reservCmd'])->name('getDeliveryWaitingCmds');
    // Route::get('delivery/{delivery_id}',"ApiCmdController@index")->name('getDeliveryWaitingCmds');
});



