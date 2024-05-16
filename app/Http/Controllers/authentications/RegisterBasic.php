<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6',
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
    // Générer un jeton d'accès
    $token = $user->createToken('token-name')->plainTextToken;

    // Retourner une réponse JSON
    return response()->json(
      [
        'status' => true,
        'message' => 'User Created Successfully',
        'token' => $token,
      ],
      200
    );
  }
}
