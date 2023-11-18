<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*USERS ROUTES */

Route::post('/users', [App\Http\Controllers\UserController::class, 'create']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'list']);


/*CLIENTS ROUTES */

Route::post('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'create']);
Route::get('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'list']);

/*BILLS ROUTES */

Route::post('/bills', [App\Http\Controllers\BillController::class, 'create']);
Route::get('/bills', [App\Http\Controllers\BillController::class, 'list']);


/*PAYMENTS ROUTES */
Route::post('/payments', [App\Http\Controllers\PaymentController::class, 'create']);
Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'list']);


Route::post('/auth/login', [App\Http\Controllers\LoginController::class, 'login']);


//PLAN ROUTES
Route::post('/plans', [App\Http\Controllers\PlanController::class, 'create']);
Route::get('/plans', [App\Http\Controllers\PlanController::class, 'list']);

//TARIFAS ROUTES
Route::post('/tarifas', [App\Http\Controllers\TarifaController::class, 'create']);
Route::get('/tarifas', [App\Http\Controllers\TarifaController::class, 'list']);

//CLIENT ROUTES
Route::post('/clients', [App\Http\Controllers\ClientController::class, 'create']);
Route::get('/clients', [App\Http\Controllers\ClientController::class, 'list']);
