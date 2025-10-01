<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->cookie('theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BookShelf') }} - @yield('title', 'Tu biblioteca personal inteligente')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Meta tags -->
    <meta name="description" content="@yield('description', 'Organiza, descubre y disfruta de tu biblioteca personal con BookShelf. La plataforma definitiva para gestionar tus libros.')">
    <meta name="keywords" content="biblioteca, libros, lectura, organizar libros, BookShelf">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="min-h-screen bg-background text-foreground">
    <div class="min-h-screen">
        @include('layouts.header')
        
        <main class="flex-1">
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>

    <!-- Toast notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script>
        // Theme management
        function setTheme(theme) {
            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(theme);
            document.cookie = `theme=${theme}; path=/; max-age=31536000`;
        }

        // Initialize theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = document.cookie
                .split('; ')
                .find(row => row.startsWith('theme='))
                ?.split('=')[1] || 'light';
            setTheme(savedTheme);
        });
    </script>
</body>
</html>
