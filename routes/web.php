<?php

use App\Models\Stores;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\SendEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('loginAdmin', ['type' => 'login']);
});

Route::get('/register', function () {
    return view('loginAdmin', ['type' => 'register']);
});

Route::get('/tests', function () {
    $ub = 'Ubicacion';
    return ucfirst($ub);
});

// Route::post('register', [UserController::class,'register']);
// Route::post('login', [UserController::class, 'authenticate']);
// Route::post('sendPassword',[UserController::class, 'sendPassword']);

// Route::group(['middleware' => ['jwt.verify']], function() {
//     Route::get('logout', [UserController::class, 'logout']);
//     Route::get('getToken', [UserController::class, 'getAuthenticatedUser']);
//     Route::post('refresh', [UserController::class, 'refresh']);

//     Route::resource('categories', CategoriesController::class);
//     Route::resource('services',ServicesController::class);
//     Route::get('getService', [ServicesController::class, 'getService']);
//     Route::resource('stores',StoresController::class);
//     Route::post('updatePassword', [UserController::class, 'updatePassword']);
// });

// Route::get('/viewServices', function () {
//     return view('services');
// });
