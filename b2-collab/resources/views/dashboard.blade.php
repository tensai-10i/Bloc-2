<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <p class="text-lg font-semibold mb-4">Vous êtes connecté!</p>
                        @if(!auth()->user()->isNormalUser())
                            <p class="mb-4"><strong>Votre rôle:</strong> {{ auth()->user()->role_display }}</p>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <div class="mb-4">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    Accéder au panneau d'administration
                                </a>
                            </div>
                        @endif
                        
                        @if(auth()->user()->isModerator())
                            <div class="mb-4">
                                <a href="{{ route('moderator.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Accéder à l'espace modérateur
                                </a>
                            </div>
                        @endif
                        
                        @if (auth()->user() && !auth()->user()->email_verified_at)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                <p class="text-yellow-800 mb-4">Veuillez vérifier votre adresse e-mail pour déverrouiller toutes les fonctionnalités.</p>
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                                        Vérifier l'adresse e-mail
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <p class="text-green-800">✓ Votre adresse e-mail a été vérifiée!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
