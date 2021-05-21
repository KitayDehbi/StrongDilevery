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



// Commands and Panier API 

Route::group(['middleware'=>'auth:api'], function () {

    //Commands
    Route::group(['prefix' => 'commands'], function() {
        Route::get('notReserved/', [ApiCmdController::class, 'deliveryWaitingCmds'])->name('getWaitingCmds');
        Route::get('reserve/{cmd_id}', [ApiCmdController::class, 'reservCmd'])->name('getDeliveryWaitingCmds');
        Route::get('annuler/{cmd_id}', [ApiCmdController::class, 'annulerCmd']);
        Route::get('dilevred/{cmd_id}', [ApiCmdController::class, 'dilevredCmd']);
        Route::post('addCmd', [ApiCmdController::class, 'addCmd']);

    });

    //Panier
    Route::group(['prefix' => 'panier'], function() {
    Route::get('allByCmd/{cmd_id}', [ApiCmdController::class, 'allPanier']);
    Route::get('delete/{panier_id}', [ApiCmdController::class, 'deletePanier']);
    });
    
    //Plats
    Route::group(['prefix' => 'plat'], function() {
    Route::get('allByResto/{resto_id}', [ApiCmdController::class, 'allPlat']);
    Route::get('get/{plat_id}', [ApiCmdController::class, 'platInfo']);
    });
    
    //Resto
    Route::group(['prefix' => 'resto'], function() {
    Route::get('allResto', [ApiCmdController::class, 'allResto']);
    Route::get('get/{resto_id}', [ApiCmdController::class, 'restoInfo']);
    });


    // Route::get('delivery/{delivery_id}',"ApiCmdController@index")->name('getDeliveryWaitingCmds');
});



