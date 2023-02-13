<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SongsController;
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

Route::get('/songs', [SongsController::class, 'getAllSongs']);
Route::prefix('albums')->group(function() {
  //Songs
  Route::controller(SongsController::class)->group(function() {
    Route::prefix('genres')->group(function() {
      Route::get('/', 'getAllGenres');
      Route::get('/{genreId}', 'getSongsByGenre');
    });
    Route::prefix('/{albumId}')->group(function() {
      Route::prefix('songs')->group(function() {
        Route::get('/', 'getMyAlbumSongs');
        Route::post('/', 'createNewSong');
        Route::prefix('/{songId}')->group(function() {
          Route::put('/', 'updateSong');
          Route::delete('/', 'deleteSong');
        });
      });
    });
  });
  // Albums
  Route::controller(AlbumsController::class)->group(function() {
    Route::get('/', 'getMyAlbums');
    Route::post('/', 'createNewAlbum');
    Route::prefix('/{id}')->group(function() {
      Route::get('/', 'getSingleAlbum');
      Route::put('/', 'updateSingleAlbum');
      Route::delete('/', 'deleteSingleAlbum');
    });
  });
});
