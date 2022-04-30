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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //Ruta de usuarios, actualizacion, muestra y deshabilitacion
    Route::put('disableUser/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'disableUser']);
    Route::patch('userUpdate/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateUser']);    
    Route::patch('updateUserInAdmin/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateUserInAdmin']);    
    Route::post('adminRegisterUser',[App\Http\Controllers\ProfileUserController::class, 'adminRegisterUser']);    
    
    Route::patch('updateFirstLogin/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateFirstLogin']);    

    Route::get('showUser',[App\Http\Controllers\ProfileUserController::class, 'index']);

    Route::get('getAllUsers',[App\Http\Controllers\ProfileUserController::class, 'getAllUsers']);
    Route::post('importUsersXML',[App\Http\Controllers\ProfileUserController::class, 'importUsersXML']);

    //Ruta de crud de eventos
    Route::resource('convocations', 'App\Http\Controllers\EventsController');    

    //Ruta de crud de eventos a los que el usuario se postuló
    // Route::resource('postulationEvents','App\Http\Controllers\EventsUsersController');  
    
    // Route::get('getPostulations',[App\Http\Controllers\EventsUsersController::class, 'getPostulations']);
});

Route::resource('gender',App\Http\Controllers\GenderController::class);
Route::get('sectors',[App\Http\Controllers\SectorsController::class,'index']);
// Route::get('competences',[App\Http\Controllers\CompetencesController::class,'index']);
Route::get('personalType',[App\Http\Controllers\PersonalTypeController::class,'index']);
//Ruta de crud de roles
//Route::get('roles', [App\Http\Controllers\RolesController::class,'index']);

Route::get('getRoles', [App\Http\Controllers\RolesController::class,'index']);
Route::get('getCompetences',[App\Http\Controllers\CompetencesController::class,'index']);

Route::post('sendPassword',[App\Http\Controllers\ProfileUserController::class, 'sendPassword']);
Route::post('updatePassword', [App\Http\Controllers\ProfileUserController::class, 'updatePassword']);
Route::get('getMyUser',[App\Http\Controllers\ProfileUserController::class, 'getMyUser']);

Route::resource('competences', 'App\Http\Controllers\CompetencesController');
Route::resource('sector', 'App\Http\Controllers\SectorsController');
Route::resource('rol','App\Http\Controllers\RolesController');
