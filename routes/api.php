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


/*CLIENTS ROUTES */

Route::post('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'create']);
Route::get('/suscriptions', [App\Http\Controllers\SuscriptionController::class, 'list']);

/*BILLS ROUTES */

Route::post('/bills', [App\Http\Controllers\BillController::class, 'create']);
Route::get('/bills', [App\Http\Controllers\BillController::class, 'list']);


Route::post('/auth/login', [App\Http\Controllers\BillController::class, 'login']);
