<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

/**=================================
 * METODOS MOVIL
 *================================**/

Route::post('/passport/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/passport/logout', [AuthController::class, 'logout']);

    //Ruta de crud de eventos
    Route::get('personalType-passport', [App\Http\Controllers\PersonalTypeController::class, 'index']);
    Route::resource('convocations-passport', 'App\Http\Controllers\EventsController');
    Route::resource('postulationEvents-passport', 'App\Http\Controllers\EventsUsersController');
    Route::post('updatePassword-passport', [App\Http\Controllers\ProfileUserController::class, 'updatePassword']);
    Route::get('sectors-passport-passport', [App\Http\Controllers\SectorsController::class, 'index']);
    Route::post('sendPassword-passport', [App\Http\Controllers\ProfileUserController::class, 'sendPassword']);
    Route::get('showUser-passport', [App\Http\Controllers\ProfileUserController::class, 'index']);
    Route::put('userUpdate-passport/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateUser']);

    Route::post('register-passport',[\App\Http\Controllers\Auth\RegisterController::class,'register']);
    Route::get('getRoles-passport', [App\Http\Controllers\RolesController::class, 'index']);
    Route::get('getCompetences-passport', [App\Http\Controllers\CompetencesController::class, 'index']);
    Route::patch('updateFirstLogin-passport/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateFirstLogin']);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //Ruta de usuarios, actualizacion, muestra y deshabilitacion
    Route::put('disableUser/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'disableUser']);
    Route::put('userUpdate/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateUser']);
    Route::patch('updateUserInAdmin/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateUserInAdmin']);
    Route::post('adminRegisterUser',[App\Http\Controllers\ProfileUserController::class, 'adminRegisterUser']);

    Route::patch('updateFirstLogin/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateFirstLogin']);
    Route::patch('updateStatusUser/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateStatusUser']);
    Route::patch('updateTokenUSer/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateTokenUSer']);


    Route::get('showUser',[App\Http\Controllers\ProfileUserController::class, 'index']);

    Route::get('getAllUsers',[App\Http\Controllers\ProfileUserController::class, 'getAllUsers']);
    Route::post('importUsersCSV',[App\Http\Controllers\ProfileUserController::class, 'importUsersCSV']);

    //Ruta de crud de eventos
    Route::resource('convocations', 'App\Http\Controllers\EventsController');

    //Ruta de crud de eventos a los que el usuario se postuló
    Route::resource('postulationEvents','App\Http\Controllers\EventsUsersController');

    Route::post('getPostulations',[App\Http\Controllers\EventsUsersController::class, 'getPostulations']);
    Route::get('getAllConvocations',[App\Http\Controllers\EventsUsersController::class, 'getAllConvocations']);
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
Route::get('getAllUsers/{name}',[App\Http\Controllers\ProfileUserController::class, 'show']);
