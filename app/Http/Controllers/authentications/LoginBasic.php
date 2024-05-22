<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $request->validate(
      [
        'email' => 'required|email',
        'password' => 'required',
      ],
      [
        'email.required' => 'L\'adresse e-mail est obligatoire.',
        'email.email' => 'L\'adresse e-mail doit être valide.',
        'password.required' => 'Le mot de passe est obligatoire.',
      ]
    );

    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
      return view('content.dashboard.dashboards-analytics');
    }

    return back()
      ->withErrors([
        'email' => 'Les informations d\'identification ne correspondent pas.',
      ])
      ->onlyInput('email');
  }
}
