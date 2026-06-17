<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/dgw-logo.png') }}">

    <title>
        @if (isset($header))
            {{ trim(strip_tags($header)) }} | DGW Loyalty
        @else
            DGW Loyalty | Smart Loyalty System
        @endif
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-900">
<div class="min-h-screen bg-slate-100">
    @auth
        @include('layouts.sidebar')
    @endauth

    <div class="@auth md:pl-64 @endauth min-h-screen">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="text-xl font-semibold leading-tight text-slate-900">
                                Smart Loyalty System DGW
                            </h2>
                        @endisset
                    </div>

                    @auth
                        <div class="hidden items-center gap-3 md:flex">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-sm font-bold text-blue-700">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <div class="md:hidden">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                        class="rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <main class="min-h-[calc(100vh-73px)] bg-slate-100">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
