<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le rôle de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            ← Retour à la liste des utilisateurs
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informations de l'utilisateur</h3>
                        <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rôle actuel</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($user->role && $user->role->name === 'super_admin')
                                            bg-red-100 text-red-800
                                        @elseif($user->role && $user->role->name === 'admin')
                                            bg-purple-100 text-purple-800
                                        @elseif($user->role && $user->role->name === 'moderator')
                                            bg-blue-100 text-blue-800
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $user->role_display }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Inscrit le</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700">Nouveau rôle</label>
                            <select id="role_id" name="role_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                @foreach($roles as $role)
                                    @if(!auth()->user()->isSuperAdmin() && $role->name === 'super_admin')
                                        @continue
                                    @endif
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ match($role->name) {
                                            'user' => 'Utilisateur normal',
                                            'moderator' => 'Modérateur',
                                            'admin' => 'Administrateur',
                                            'super_admin' => 'Super Administrateur',
                                            default => ucfirst(str_replace('_', ' ', $role->name))
                                        } }}
                                        (Niveau {{ $role->level }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('admin.users.index') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">
                                Mettre à jour le rôle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>