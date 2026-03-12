<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Email Verification Section -->
            @if (auth()->user() && !auth()->user()->email_verified_at)
                <div class="p-4 sm:p-8 bg-yellow-50 border border-yellow-200 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-semibold text-yellow-900 mb-4">Vérifier votre adresse e-mail</h3>
                        <p class="text-yellow-800 mb-6">Veuillez vérifier votre adresse e-mail pour déverrouiller toutes les fonctionnalités.</p>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 px-4 rounded">
                                Envoyer l'e-mail de vérification
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="p-4 sm:p-8 bg-green-50 border border-green-200 shadow sm:rounded-lg">
                    <p class="text-green-800 font-semibold">✓ Votre adresse e-mail a été vérifiée!</p>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
