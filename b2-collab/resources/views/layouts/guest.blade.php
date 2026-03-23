<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RESources Relationnelles') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.header')

        <main class="auth-main">
            <section class="auth-shell">
                <div class="auth-brand">
                    <a href="{{ route('home') }}">RESources Relationnelles</a>
                </div>

                <div class="auth-card">
                    {{ $slot }}
                </div>
            </section>
        </main>

        @include('layouts.footer')
    </body>
</html>
