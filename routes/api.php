<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



/**=================================
 * METODOS MOVIL
 *================================**/

Route::get('/passport/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/passport/logout', [AuthController::class, 'logout']);

    //Ruta de crud de eventos
    Route::get('personalType', [App\Http\Controllers\PersonalTypeController::class, 'index']);
    Route::resource('convocations-passport', 'App\Http\Controllers\EventsController');
    Route::resource('postulationEvents', 'App\Http\Controllers\EventsUsersController');
    Route::post('updatePassword', [App\Http\Controllers\ProfileUserController::class, 'updatePassword']);
    Route::get('sectors-passport', [App\Http\Controllers\SectorsController::class, 'index']);
    Route::post('sendPassword', [App\Http\Controllers\ProfileUserController::class, 'sendPassword']);
    Route::get('showUser', [App\Http\Controllers\ProfileUserController::class, 'index']);
    Route::put('userUpdate/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateUser']);

    Route::post('register-passport',[\App\Http\Controllers\Auth\RegisterController::class,'register']);
    Route::get('getRoles-passport', [App\Http\Controllers\RolesController::class, 'index']);
    Route::get('getCompetences-passport', [App\Http\Controllers\CompetencesController::class, 'index']);
    Route::patch('updateFirstLogin/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateFirstLogin']);

});



Route::group(['middleware' => ['auth']], function () {


    //Ruta de usuarios, actualizacion, muestra y deshabilitacion
    Route::put('disableUser/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'disableUser']);

//    Route::put('userUpdate/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateUser']);

    Route::patch('updateUserInAdmin/{user_id}', [App\Http\Controllers\ProfileUserController::class, 'updateUserInAdmin']);

    Route::post('adminRegisterUser', [App\Http\Controllers\ProfileUserController::class, 'adminRegisterUser']);

    Route::get('getRoles', [App\Http\Controllers\RolesController::class, 'index']);
    Route::get('getCompetences', [App\Http\Controllers\CompetencesController::class, 'index']);
//    Route::get('showUser', [App\Http\Controllers\ProfileUserController::class, 'index']);
    Route::get('sectors', [App\Http\Controllers\SectorsController::class, 'index']);

    Route::get('getAllUsers', [App\Http\Controllers\ProfileUserController::class, 'getAllUsers']);
    Route::post('importUsersCSV', [App\Http\Controllers\ProfileUserController::class, 'importUsersCSV']);


    Route::get('getAllConvocations', [App\Http\Controllers\EventsUsersController::class, 'getAllConvocations']);
    Route::get('convocationDetail ', [EventsController::class,'show']);

    Route::resource('convocations', 'App\Http\Controllers\EventsController');

    Route::post('getPostulations', [App\Http\Controllers\EventsUsersController::class, 'getPostulations']);
//    Route::get('getAllConvocations', [App\Http\Controllers\EventsUsersController::class, 'getAllConvocations']);

    Route::get('events', [EventsController::class, 'index']);

});





Route::resource('gender', App\Http\Controllers\GenderController::class);

// Route::get('competences',[App\Http\Controllers\CompetencesController::class,'index']);

//Ruta de crud de roles
//Route::get('roles', [App\Http\Controllers\RolesController::class,'index']);






Route::get('getMyUser', [App\Http\Controllers\ProfileUserController::class, 'getMyUser']);

Route::resource('competences', 'App\Http\Controllers\CompetencesController');
Route::resource('sector', 'App\Http\Controllers\SectorsController');
Route::resource('rol', 'App\Http\Controllers\RolesController');
Route::get('getAllUsers/{name}', [App\Http\Controllers\ProfileUserController::class, 'show']);
