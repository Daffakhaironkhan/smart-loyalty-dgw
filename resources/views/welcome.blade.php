<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DGW Loyalty | Smart Loyalty System</title>

    <link rel="icon" type="image/png" href="{{ asset('images/dgw-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white antialiased">
<div class="relative min-h-screen overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950"></div>
    <div class="absolute -left-32 top-20 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl"></div>
    <div class="absolute -right-32 bottom-20 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>

    <header class="relative z-10 mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white p-1 shadow-lg">
                <img src="{{ asset('images/dgw-logo.png') }}"
                     alt="DGW Logo"
                     class="h-full w-full object-contain">
            </div>

            <div>
                <p class="text-lg font-bold leading-tight">
                    DGW Loyalty
                </p>
                <p class="text-xs text-blue-100">
                    Smart Loyalty System
                </p>
            </div>
        </a>

        @if (Route::has('login'))
            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-blue-900 transition hover:bg-blue-50">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-xl border border-white/20 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="hidden rounded-xl bg-white px-4 py-2 text-sm font-semibold text-blue-900 transition hover:bg-blue-50 sm:inline-flex">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="relative z-10 mx-auto grid min-h-[calc(100vh-96px)] max-w-7xl grid-cols-1 items-center gap-10 px-6 pb-16 pt-8 lg:grid-cols-2 lg:px-8">
        <section>
            <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100 backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-green-400"></span>
                Integrated loyalty platform for DGW
            </div>

            <h1 class="mt-6 max-w-3xl text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Kelola poin, transaksi, dan reward dalam satu sistem.
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                DGW Loyalty membantu Admin, Toko/Kios, dan Konsumen mengelola transaksi pembelian, perhitungan poin, validasi data, hingga penukaran reward secara lebih rapi dan terintegrasi.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-bold text-blue-900 shadow-lg transition hover:bg-blue-50">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-bold text-blue-900 shadow-lg transition hover:bg-blue-50">
                        Masuk ke Sistem
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-white/20 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">
                            Buat Akun
                        </a>
                    @endif
                @endauth
            </div>

            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-2xl font-bold text-white">3</p>
                    <p class="mt-1 text-sm text-slate-300">Role utama</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-2xl font-bold text-white">2</p>
                    <p class="mt-1 text-sm text-slate-300">Jenis transaksi poin</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                    <p class="text-2xl font-bold text-white">1</p>
                    <p class="mt-1 text-sm text-slate-300">Dashboard terintegrasi</p>
                </div>
            </div>
        </section>

        <section class="relative">
            <div class="rounded-[2rem] border border-white/10 bg-white/10 p-6 shadow-2xl backdrop-blur-xl">
                <div class="rounded-[1.5rem] bg-white p-6 text-slate-900 shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">
                                Smart Loyalty System
                            </p>
                            <h2 class="mt-1 text-2xl font-bold">
                                DGW Loyalty
                            </h2>
                        </div>

                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-14 w-20 object-contain">
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Admin
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Validasi transaksi, kelola master data, dan pantau laporan.
                                    </p>
                                </div>
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Control
                                    </span>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Toko/Kios
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Input transaksi konsumen dan pembelian ke DGW.
                                    </p>
                                </div>
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Earn Points
                                    </span>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        Konsumen
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Cek poin, riwayat transaksi, dan tukarkan reward.
                                    </p>
                                </div>
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                        Redeem
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 rounded-2xl bg-blue-600 p-5 text-white">
                        <p class="text-sm text-blue-100">
                            Sistem berjalan untuk mendukung loyalty program yang lebih transparan, terukur, dan mudah dipantau.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
