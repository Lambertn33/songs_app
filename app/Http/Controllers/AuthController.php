<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:api', ['except' => ['login','register']]);
  }

  public function login(Request $request)
  {
      $request->validate([
          'email' => 'required|string|email',
          'password' => 'required|string',
      ]);
      $credentials = $request->only('email', 'password');

      $token = auth('api')->attempt($credentials);
      if (!$token) {
        return response()->json([
          'status' => 'error',
          'message' => 'Unauthorized',
        ], 401);
      }

      $user = Auth::user();
      return response()->json([
        'status' => 'success',
        'authorisation' => [
          'token' => $token,
          'type' => 'bearer',
        ]
      ], 200);
  }

  public function register(Request $request)
  {
    try {
      $names = $request->names;
      $email = $request->email;
      $password = $request->password;

      if (!$names || !$email || !$password) {
        return response()->json([
          'status' => 'error',
          'message' => 'please fill all the fields',
        ], 400); 
      }

      if (strlen($password) < 6) {
        return response()->json([
          'status' => 'error',
          'message' => 'the password should be at least 6 characters',
        ], 400);
      }

      DB::beginTransaction();
      $checkEmailExistence = User::where('email', $email);

      if ($checkEmailExistence->exists()) {
        return response()->json([
          'status' => 'error',
          'message' => 'the email provided is already taken',
        ], 400);
      }

      $user = User::create([
          'id' => Str::uuid()->toString(),
          'names' => $names,
          'email' => $email,
          'password' => Hash::make($password),
          'created_at' => now(),
          'updated_at' => now() 
      ]);

      $token = Auth::login($user);
      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'User created successfully',
        'authorisation' => [
          'token' => $token,
          'type' => 'bearer',
        ]
      ], 200); 

      } catch (\Throwable $th) {
        DB::rollback();
        return response()->json([
          'status' => 'error',
          'message' => 'an error occured.... please try again',
        ], 500); 
      }
  }

  public function logout()
  {
    try {
      Auth::logout();
      return response()->json([
          'status' => 'success',
          'message' => 'Successfully logged out',
      ], 200);
    } catch(\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => 'an error occured.... please try again',
      ], 500); 
    }
  }
}
