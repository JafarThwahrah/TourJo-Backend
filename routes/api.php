<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BookedtourController;
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
Route::get('/gettours', [TourController::class, "index"]);
Route::get('/getsingletour/{id}', [TourController::class, "getsingletour"]);
Route::get('/getbookedtour/{userRole}/{userid}', [BookedtourController::class, "bookedToursEachUser"]);
Route::get('/getalladvisors', [AuthController::class, "getalladvisors"]);
Route::post('/googlelogin', [AuthController::class, "googlelogin"]);
Route::get('/getTestimonials', [BookedtourController::class, "getTestimonials"]);
Route::get('/getallusers', [AuthController::class, "getallusers"]);
Route::get('/getalltours', [TourController::class, "getalltours"]);
Route::get('/getallbookedtours', [BookedtourController::class, "getallbookedtours"]);
Route::post('/newdestination', [DestinationController::class, "newdestination"]);
Route::get('/getoneuser/{id}', [AuthController::class, "getoneuser"]);
Route::get('/about', [TourController::class, "about"]);
Route::get('/toursnumbers', [TourController::class, "toursnumbers"]);
Route::get('/getFavorites/{id}', [WishlistController::class, "getFavorites"]);
Route::get('/getwishwithtours/{id}', [WishlistController::class, "getwishwithtours"]);











Route::delete('/deleteUser/{id}', [AuthController::class, "destroy"]);
// Route::delete('/deletetour/{id}', [TourController::class, "destroy"]);









//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/tours', [TourController::class, "store"]);
    Route::post('/checkouttour', [BookedtourController::class, "bookedtourstore"]);
    Route::put('/tours/{id}', [TourController::class, "update"]);
    Route::post('/user/{id}', [AuthController::class, "update"]);
    Route::delete('/tours/{id}', [TourController::class, "destroy"]);
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::post('/rateandreview', [BookedtourController::class, "rateandreview"]);
    Route::post('/addtoWishlist', [WishlistController::class, "addtoWishlist"]);
    Route::post('/editpublishedtour/{id}', [TourController::class, "editpublishedtour"]);
    Route::post('/removefromFav', [WishlistController::class, "removefromFav"]);
});
