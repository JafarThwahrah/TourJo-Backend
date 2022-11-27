<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DestinationController;

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


// public Routes
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::get('/destinations', [DestinationController::class, "index"]);
Route::get('/gettours/{userid}', [TourController::class, "getToutsPerUser"]);




//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/tours', [TourController::class, "store"]);
    Route::put('/tours/{id}', [TourController::class, "update"]);
    Route::post('/tours/{id}', [TourController::class, "destroy"]);
    Route::post('/logout', [AuthController::class, "logout"]);
});
