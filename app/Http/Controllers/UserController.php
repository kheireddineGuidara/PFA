<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('admin.index', compact('users'));
  }

  public function create()
  {
    $roles = Role::all();
    return view('admin.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6',
      'role' => 'required',
    ]);

    $user = User::create([
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => bcrypt($validated['password']),
    ]);

    $user->assignRole($validated['role']);

    return redirect()
      ->route('admin.index')
      ->with('success', 'Utilisateur créé avec succès.');
  }

  public function edit(User $user)
  {
    $roles = Role::all();
    return view('admin.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'role' => 'required',
    ]);

    $user->update([
      'name' => $validated['name'],
      'email' => $validated['email'],
    ]);

    $user->syncRoles($validated['role']);

    return redirect()
      ->route('admin.index')
      ->with('success', 'Utilisateur mis à jour avec succès.');
  }

  public function destroy(User $user)
  {
    $user->delete();
    return redirect()
      ->route('admin.index')
      ->with('success', 'Utilisateur supprimé avec succès.');
  }
}
