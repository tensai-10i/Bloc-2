<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Profile Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Prénom</h3>
                            <p class="mt-1 text-lg">{{ $user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">E-mail</h3>
                            <p class="mt-1 text-lg">{{ $user->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Membre depuis</h3>
                            <p class="mt-1 text-lg">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase">Dernière mise à jour</h3>
                            <p class="mt-1 text-lg">{{ $user->updated_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    @auth
                        @if (auth()->user()->id === $user->id)
                            <div class="mt-8 flex gap-4">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Modifier votre profil
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
