<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    //Ruta de usuarios, actualizacion, muestra y deshabilitacion
    Route::put('disableUser/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'disableUser']);
    Route::put('userUpdate/{user_id}',[App\Http\Controllers\ProfileUserController::class, 'updateUser']);    
    Route::get('showUser',[App\Http\Controllers\ProfileUserController::class, 'index']);

    //Ruta de crud de eventos
    Route::resource('events', 'App\Http\Controllers\EventsController');

    //Ruta de crud de eventos a los que el usuario se postuló
    Route::resource('postulationEvents','App\Http\Controllers\EventsUsersController');    
});

Route::resource('gender',App\Http\Controllers\GenderController::class);
Route::get('sectors',[App\Http\Controllers\SectorsController::class,'index']);
// Route::get('competences',[App\Http\Controllers\CompetencesController::class,'index']);
Route::get('personalType',[App\Http\Controllers\PersonalTypeController::class,'index']);
//Ruta de crud de roles
//Route::get('roles', [App\Http\Controllers\RolesController::class,'index']);

Route::get('getRoles', [App\Http\Controllers\RolesController::class,'index']);
Route::get('getCompetences',[App\Http\Controllers\CompetencesController::class,'index']);