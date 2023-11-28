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
Route::get('/users/restore/{id}', [App\Http\Controllers\UserController::class, 'restorepassword']);
Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'destroy']);
Route::post('/users/changepassword', [App\Http\Controllers\UserController::class, 'changepassword']);


/*CLIENTS ROUTES */

Route::post('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'create']);
Route::get('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'list']);
Route::post('/suscriptions/renew', [App\Http\Controllers\SuscriptionController::class, 'renew']);

/*BILLS ROUTES */

Route::post('/bills', [App\Http\Controllers\BillController::class, 'create']);
Route::get('/bills', [App\Http\Controllers\BillController::class, 'list']);
Route::get('/bills/by-code/{code}', [App\Http\Controllers\BillController::class, 'findByCode']);
Route::get('/bills/print/normal/{code}', [App\Http\Controllers\BillController::class, 'printNormal']);


/*PAYMENTS ROUTES */
Route::post('/payments', [App\Http\Controllers\PaymentController::class, 'create']);
Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'list']);
Route::get('/payments/print/ticket/{code}', [App\Http\Controllers\PaymentController::class, 'printTicket']);




Route::post('/auth/login', [App\Http\Controllers\LoginController::class, 'login']);


//PLAN ROUTES
Route::post('/plans', [App\Http\Controllers\PlanController::class, 'create']);
Route::get('/plans', [App\Http\Controllers\PlanController::class, 'list']);

//TARIFAS ROUTES
Route::post('/tarifas', [App\Http\Controllers\TarifaController::class, 'create']);
Route::get('/tarifas', [App\Http\Controllers\TarifaController::class, 'list']);

//CLIENT ROUTES
Route::post('/clients', [App\Http\Controllers\ClientController::class, 'create']);
Route::post('/clients/update', [App\Http\Controllers\ClientController::class, 'update']);

Route::get('/clients', [App\Http\Controllers\ClientController::class, 'list']);
Route::get('/clients/by-names/{names}', [App\Http\Controllers\ClientController::class, 'listByNames']);
Route::get('/clients/by-surnames/{surnames}', [App\Http\Controllers\ClientController::class, 'listBySurnames']);
Route::get('/clients/by-identification/{identification}', [App\Http\Controllers\ClientController::class, 'listByIdentification']);
Route::get('/clients/by-id/{id}', [App\Http\Controllers\ClientController::class, 'findById']);


//REPORTE ROUTES
Route::get('/reports/clients', [App\Http\Controllers\ReporteController::class, 'reporteClientes']);
Route::get('/reports/payments', [App\Http\Controllers\ReporteController::class, 'reportePagos']);
Route::get('/reports/bills', [App\Http\Controllers\ReporteController::class, 'reporteFacturas']);
Route::get('/reports/suscriptions', [App\Http\Controllers\ReporteController::class, 'reporteSuscripciones']);

//MESSAGES ROUTES
Route::post('/messages/normal', [App\Http\Controllers\MessageController::class, 'sendmessage']);
Route::post('/messages/bill', [App\Http\Controllers\MessageController::class, 'sendbill']);

