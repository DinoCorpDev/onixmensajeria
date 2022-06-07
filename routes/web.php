<?php

use App\Events\CreateEvents;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|   https://ankurk91.github.io/vue-loading-overlay/
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/tests', function () {
    event(new CreateEvents());
    return "Se escucho 2";
});
