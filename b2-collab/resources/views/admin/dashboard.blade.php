@extends('layouts.app')

@section('title', 'Gestion')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Espace de gestion</h1>
                <p class="mb-6">Cette page centralise les actions de gestion.</p>

                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('ressources.index') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-700 transition">
                        Gerer les ressources
                    </a>
                    <a href="{{ route('category.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">
                        Gerer les categories
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Gerer les roles utilisateurs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
