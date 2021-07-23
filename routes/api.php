<?php

use App\Http\Controllers\CustomersApiController;
use App\Http\Controllers\AuthorizationApiController;
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

Route::post('/login', [AuthorizationApiController::class,'authenticate']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/customers', [CustomersApiController::class,'index']);
    Route::post('/customers', [CustomersApiController::class,'store']);
    Route::get('/customers/{customer}', [CustomersApiController::class,'show']);
    Route::put('/customers/{customer}', [CustomersApiController::class,'update']);
    Route::delete('/customers/{customer}', [CustomersApiController::class,'destroy']);
    Route::post('/logout', [AuthorizationApiController::class,'logout']);
});
