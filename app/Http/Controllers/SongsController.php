<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Song;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class SongsController extends Controller
{
  public $authenticatedUser;

  public function __construct()
  {
    $this->middleware('auth:api');
    $this->middleware(function ($request, $next)
    {
      $this->authenticatedUser = Auth::user();
      return $next($request);
    });
  }

  public function getMyAlbumSongs($albumId)
  {
    $songs = [];
    $albumToView = Album::with('songs')->find($albumId);
    if (!$albumToView) {
      return response()->json([
        'status' => 'error',
        'message' => 'album not found',
      ]);
    }

    $albumSongs = $albumToView->songs()->get();
    foreach ($albumSongs as $song) {
      $songs[] = [
        'id' => $song->id,
        'genre' => $song->genre->name,
        'title' => $song->title,
        'length' => $song->length
      ];
    }
    return response()->json([
      'status' => 'success',
      'message' => 'songs for album described ' .$albumToView->description. ' ',
      'songs' => $songs
    ]);
  }

  public function getAllGenres()
  {
    $allGenres = Genre::select(['id', 'name'])->get();
    return response()->json([
      'status' => 'success',
      'message' => 'all genres',
      'songs' => $allGenres
    ]);
  }

  public function createNewSong(Request $request, $albumId)
  {
    try {
      DB::beginTransaction();
      $genreId = $request->genreId;
      $title = $request->title;
      $length = $request->length;

      if (!$genreId || !$title || !$length) {
        return response()->json([
          'status' => 'error',
          'message' => 'please fill all fields and select the genre',
        ]);
      }

      $newSong = [
        'id' => Str::uuid()->toString(),
        'title' => $title,
        'length' => $length,
        'album_id' => $albumId,
        'genre_id' => $genreId,
        'created_at' => now(),
        'updated_at' => now()
      ];

      Song::insert($newSong);
      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'new song created successfully',
      ]);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ]);
    }
  }

  public function updateSong(Request $request, $albumId, $songId)
  {
    try {
      DB::beginTransaction();
      $genreId = $request->genreId;
      $title = $request->title;
      $length = $request->length;
      $albumToUpdateIn = Album::find($albumId);
      $songToUpdate = Song::find($songId);

      if (!$albumToUpdateIn) {
        return response()->json([
          'status' => 'error',
          'message' => 'album not found',
        ]);
      }

      if (!$songToUpdate) {
        return response()->json([
          'status' => 'error',
          'message' => 'song not found',
        ]);
      }

      $songToUpdate->update([
        'genreId' => $genreId ? $genreId : $songToUpdate->genreId,
        'title' => $title ? $title : $songToUpdate->title,
        'length' => $length ? $length : $songToUpdate->length
      ]);

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'song updated successfully',
        'updated_album' => $songToUpdate
      ]);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ]);
    }
  }

  public function deleteSong($albumId, $songId) 
  {
    try {
      DB::beginTransaction();
      $songToDelete = Song::find($songId);
      if (!$songToDelete) {
        return response()->json([
          'status' => 'error',
          'message' => 'song not found',
        ]);
      }
      $songToDelete->delete();
      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'song deleted successfully',
      ]);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ]);
    }
  }
}
