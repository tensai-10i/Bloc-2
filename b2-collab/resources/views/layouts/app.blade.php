<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'RESources Relationnelles')</title>
    <link rel="icon" type="image/png" href="/ressourceR.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>
<body>

    @include('layouts.header')

    @isset($header)
        <header>
            <div class="container" style="padding-top: 10px;">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @include('layouts.footer')

</body>
</html>
