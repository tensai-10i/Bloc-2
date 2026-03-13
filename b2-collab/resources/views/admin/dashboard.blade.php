<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panneau d'administration
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold mb-4">Bienvenue dans le panneau d'administration!</p>

                    <div class="mb-6">
                        <p><strong>Rôle actuel:</strong> {{ auth()->user()->role_display }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('admin.users.index') }}" class="bg-blue-50 border border-blue-200 rounded-md p-4 hover:bg-blue-100 transition-colors cursor-pointer">
                            <h3 class="font-semibold text-blue-800">Gestion des utilisateurs</h3>
                            <p class="text-blue-600">Gérer les comptes utilisateurs et leurs rôles</p>
                        </a>

                        <div class="bg-green-50 border border-green-200 rounded-md p-4">
                            <h3 class="font-semibold text-green-800">Modération</h3>
                            <p class="text-green-600">Outils de modération du contenu</p>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-md p-4">
                            <h3 class="font-semibold text-purple-800">Paramètres système</h3>
                            <p class="text-purple-600">Configuration du système</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>