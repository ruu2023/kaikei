<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        {{-- 2025年4月29日追加 nav bar --}}
        <!-- ナビゲーション -->
        <nav class="bottom-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>ホーム</span>
            </a>
            <a href="{{ route('transaction') }}"
                class="nav-item {{ request()->routeIs('transaction') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i>
                <span>取引</span>
            </a>
            <a href="{{ route('analytics') }}" class="nav-item {{ request()->routeIs('analytics') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>分析</span>
            </a>
            <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>設定</span>
            </a>
        </nav>


    </div>
</body>

</html>
