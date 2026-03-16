@extends('layouts.app')

@section('title', 'Gestion des roles')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Gestion des roles</h1>

                @if (session('status') === 'role-updated')
                    <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-green-800">
                        Role utilisateur mis a jour.
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Nom</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Role</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex items-center justify-end gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="rounded-md border-gray-300 text-sm">
                                                <option value="superadmin" @selected($user->role === 'superadmin')>Super administrateur</option>
                                                <option value="user" @selected($user->role === 'user')>Utilisateur</option>
                                                <option value="moderator" @selected($user->role === 'moderator')>Moderateur</option>
                                                <option value="admin" @selected($user->role === 'admin')>Administrateur</option>
                                            </select>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                                Enregistrer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Aucun utilisateur trouve.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
