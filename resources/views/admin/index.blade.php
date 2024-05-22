@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Utilisateurs</h1>
    <a href="{{ route('admin.create') }}" class="btn btn-primary">Créer un Utilisateur</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $user) }}" class="btn btn-warning">Éditer</a>
                        <form action="{{ route('admin.destroy', $user) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
