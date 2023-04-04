<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\SendEmailController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return view('LoginAdmin');
});

Route::post('register', [UserController::class, 'register']);
Route::post('registerWithMovil', [UserController::class, 'registerMovil']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('loginWithMovil', [UserController::class, 'authenticateMovil']);
Route::post('sendPassword', [UserController::class, 'sendPassword']);
Route::post('providerCreate', [UserController::class, 'createProvider']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('getProfile', [UserController::class, 'getAuthenticatedUser']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('getToken', [UserController::class, 'getAuthenticatedUser']);
    Route::post('refresh', [UserController::class, 'refresh']);

    Route::get('users', [UserController::class, 'index']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);

    Route::post('userCreate', [UserController::class, 'createUserInAdmin']);
    Route::put('userUpdate/{id_user}', [UserController::class, 'updateUserInAdmin']);

    Route::resource('categories', CategoriesController::class);

    Route::get('getServicesName', [ServicesController::class, 'getServicesName']);
    Route::get('getMyServicesName', [ServicesController::class, 'getMyServicesName']);

    Route::get('getCategoriesName', [CategoriesController::class, 'getCategoriesName']);

    Route::resource('services', ServicesController::class);
    Route::get('my-services', [ServicesController::class, 'myServices']);


    Route::resource('roles', RolesController::class);
    Route::get('getService', [ServicesController::class, 'getService']);

    Route::resource('stores', StoresController::class);

    Route::post('updatePassword', [UserController::class, 'updatePassword']);

    Route::get('getAllStores', [StoresController::class, 'getAllStores']);
    Route::get('getMyStores', [StoresController::class, 'getMyStores']);
});

Route::get('/viewServices', function () {
    return view('services');
});
