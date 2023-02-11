<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function() {
  Route::post('login', 'login');
  Route::post('register', 'register');
  Route::post('logout', 'logout');
});

Route::controller(AlbumsController::class)->prefix('albums')->group(function() {
  Route::get('/', 'getMyAlbums');
  Route::post('/', 'createNewAlbum');
  Route::get('/{id}', 'getSingleAlbum');
  Route::put('/{id}', 'updateSingleAlbum');
  Route::delete('/{id}', 'deleteSingleAlbum');
});
