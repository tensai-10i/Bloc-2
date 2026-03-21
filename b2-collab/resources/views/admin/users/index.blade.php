@extends('layouts.app')

@section('title', 'Gestion des rôles')

@section('content')
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-title-block">
            <p class="page-kicker">Administration</p>
            <h1>Gestion des rôles</h1>
            <p class="page-subtitle">La gestion des utilisateurs reprend désormais les mêmes surfaces, contrastes et boutons que le reste du site.</p>
        </div>
    </div>

    @if (session('status') === 'role-updated')
        <div class="alert alert-success">Rôle utilisateur mis à jour.</div>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-600">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="meta-badge">{{ $user->roleDisplay() }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="actions-cell">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-control select-compact">
                                        <option value="superadmin" @selected($user->role === 'superadmin')>Super administrateur</option>
                                        <option value="user" @selected($user->role === 'user')>Utilisateur</option>
                                        <option value="moderator" @selected($user->role === 'moderator')>Modérateur</option>
                                        <option value="admin" @selected($user->role === 'admin')>Administrateur</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state empty-state-compact">
                                    <p>Aucun utilisateur trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
        <div class="pagination-shell">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
