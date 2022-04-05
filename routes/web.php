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

    //Ruta de crud de roles
    Route::resource('roles', 'App\Http\Controllers\RolesController');

    //Ruta de crud de eventos
    Route::resource('events', 'App\Http\Controllers\EventsController');

    //Ruta de crud de eventos a los que el usuario se postuló
    Route::resource('postulationEvents','App\Http\Controllers\EventsUsersController');    
});

Route::resource('gender','App\Http\Controllers\GenderController');
Route::resource('sectors','App\Http\Controllers\SectorsController');
Route::resource('competences','App\Http\Controllers\CompetencesController');
Route::resource('personalType','App\Http\Controllers\PersonalTypeController');