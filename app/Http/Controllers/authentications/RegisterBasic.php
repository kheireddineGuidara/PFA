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
    $rules = [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6',
    ];

    $messages = [
      'name.required' => 'Le nom est obligatoire.',
      'email.required' => 'L\'adresse e-mail est obligatoire.',
      'email.email' => 'L\'adresse e-mail doit être valide.',
      'email.unique' => 'L\'adresse e-mail a déjà été prise.',
      'password.required' => 'Le mot de passe est obligatoire.',
      'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
    ];

    $request->validate($rules, $messages);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return redirect()
      ->route('auth-register-basic')
      ->with('success', 'Your registration has been successful!');
  }
}
