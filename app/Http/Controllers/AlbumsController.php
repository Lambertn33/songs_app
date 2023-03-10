<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
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

  public function getMyAlbums()
  {
    $authenticatedUser = $this->authenticatedUser;
    $myAlbums = [];
    $albums = $authenticatedUser->albums()->orderBy('title', 'asc')->get();
    foreach ($albums as $album) {
      $myAlbums[] = [
        'id' => $album->id,
        'title' => $album->title,
        'description' =>  $album->description,
        'image' =>  $album->getAlbumImage(),
        'release_date' => $album->release_date,
        'number_of_songs' => $album->songs()->count()
      ];
    }
    return response()->json([
      'status' => 'success',
      'message' => 'my albums',
      'albums' => $myAlbums
    ], 200);
  }

  public function createNewAlbum(Request $request)
  {
    try {
      $authenticatedUser = $this->authenticatedUser;
      $title = $request->title;
      $description = $request->description;
      $release_date = $request->release_date;
      $image = $request->file('image');

      if (!$title || !$description || !$release_date || !$image) {
        return response()->json([
          'status' => 'error',
          'message' => 'please fill all fields and upload the image',
        ], 400);
      }

      $checkTitle = Album::where('user_id', $authenticatedUser->id)
        ->where('title', $title);
      if ($checkTitle->exists()) {
        return response()->json([
          'status' => 'error',
          'message' => 'you already have an album entitled '.$title.'.. please get another title ',
        ], 400);
      }
      
      $imageName = time() . '_'.Str::random(8).'.' .$image->getClientOriginalExtension();
      $imagePathInDb = '/'. $authenticatedUser->id. '/'. $imageName;
      $path = '/'. $authenticatedUser->id;
      $image->storeAs($path, $imageName , 'images');
      
      $newAlbum = [
        'id' => Str::uuid()->toString(),
        'user_id'=> $authenticatedUser->id,
        'title' => $title,
        'description' => $description,
        'release_date' => $release_date,
        'image' => $imagePathInDb,
        'created_at' => now(),
        'updated_at' => now(),
      ];

      Album::insert($newAlbum);
      return response()->json([
        'status' => 'success',
        'message' => 'new Album created successfully',
        'album' => $newAlbum
      ], 201);
      

    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ], 500);
    }
  }

  public function getSingleAlbum($id)
  {
    $albumToView = Album::find($id, ['id', 'title', 'description', 'release_date']);
    if (!$albumToView) {
      return response()->json([
        'status' => 'error',
        'message' => 'album not found',
      ], 404);
    }
    return response()->json([
      'status' => 'success',
      'message' => 'single Album',
      'album' => $albumToView
    ], 200);
  }

  public function updateSingleAlbum(Request $request, $id)
  {
    try {
      DB::beginTransaction();
      $title = $request->title;
      $description = $request->description;
      $release_date = $request->release_date;
      $albumToUpdate = Album::find($id);
      if (!$albumToUpdate) {
        return response()->json([
          'status' => 'error',
          'message' => 'album not found',
        ], 404);
      }

      if (!$title || !$description || !$release_date) {
        return response()->json([
          'status' => 'error',
          'message' => 'please fill all fields',
        ], 400);
      }

      $albumToUpdate->update([
        'title' => $title,
        'description' => $description,
        'release_date' => $release_date
      ]);

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'album updated successfully',
        'updated_album' => $albumToUpdate
      ], 200);
      
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ], 500);
    }
  }

  public function deleteSingleAlbum($id)
  {
    try {
      DB::beginTransaction();
      $albumToDelete = Album::with('songs')->find($id);

      if (!$albumToDelete) {
        return response()->json([
          'status' => 'error',
          'message' => 'album not found',
        ], 404);
      }

      // first delete every song in the album
      if ($albumToDelete->songs()->count() > 0) {
        foreach ($albumToDelete->songs as $song) {
          $song->delete();
        }
      }

      Storage::disk('images')->delete($albumToDelete->image);

      // delete album cover in the storage folder
      $albumToDelete->delete();
      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'Album and related songs deleted successfully',
      ], 200);
    } catch (\Throwable $th) {
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ], 500);
    }
  }
}
