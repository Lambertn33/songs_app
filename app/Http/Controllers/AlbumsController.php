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
    $myAlbums = $authenticatedUser->albums()->get();
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
      $description = $request->description;
      $release_date = $request->release_date;
      $image = $request->file('image');

      if (!$description || !$release_date || !$image) {
        return response()->json([
          'status' => 'error',
          'message' => 'please fill all fields and upload the image',
        ], 400);
      }
      
      $imageName = time() . '_'.Str::random(8).'.' .$image->getClientOriginalExtension();
      $imagePathInDb = '/'. $authenticatedUser->id. '/'. $imageName;
      $path = '/'. $authenticatedUser->id;
      $image->storeAs($path, $imageName , 'images');
      
      $newAlbum = [
        'id' => Str::uuid()->toString(),
        'user_id'=> $authenticatedUser->id,
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
    $albumToView = Album::find($id);
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
      $description = $request->description;
      $release_date = $request->release_date;
      $albumToUpdate = Album::find($id);
      if (!$albumToUpdate) {
        return response()->json([
          'status' => 'error',
          'message' => 'album not found',
        ], 404);
      }

      $albumToUpdate->update([
        'description' => $description ? $description : $albumToUpdate->description,
        'release_date' => $release_date ? $release_date : $albumToUpdate->release_date
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
