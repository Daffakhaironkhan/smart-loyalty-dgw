<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DGW Loyalty | Smart Loyalty System</title>

    <link rel="icon" type="image/png" href="{{ asset('images/dgw-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-gray-900 antialiased">
<div class="relative min-h-screen overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950"></div>
    <div class="absolute -left-32 top-20 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl"></div>
    <div class="absolute -right-32 bottom-20 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>

    <div class="relative z-10 grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <section class="hidden flex-col justify-between p-12 text-white lg:flex">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg">
                    <img src="{{ asset('images/dgw-logo.png') }}"
                         alt="DGW Logo"
                         class="h-full w-full object-contain">
                </div>

                <div>
                    <p class="text-xl font-bold leading-tight">
                        DGW Loyalty
                    </p>
                    <p class="text-sm text-blue-100">
                        Smart Loyalty System
                    </p>
                </div>
            </a>

            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-green-400"></span>
                    Integrated loyalty platform for DGW
                </div>

                <h1 class="mt-6 max-w-xl text-4xl font-bold leading-tight">
                    Kelola poin, transaksi, dan reward dalam satu sistem.
                </h1>

                <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">
                    Satu platform untuk Admin, Toko/Kios, dan Konsumen dalam mengelola transaksi, validasi, poin, reward, dan laporan loyalty program.
                </p>

                <div class="mt-8 grid max-w-lg grid-cols-1 gap-4">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="font-semibold">Validasi transaksi</p>
                        <p class="mt-1 text-sm text-blue-100">
                            Admin dapat memantau dan memvalidasi transaksi Konsumen maupun pembelian Toko/Kios.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="font-semibold">Poin & reward</p>
                        <p class="mt-1 text-sm text-blue-100">
                            Perhitungan poin dan penukaran reward dapat dikelola dalam satu dashboard.
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-sm text-blue-100">
                © {{ date('Y') }} DGW Loyalty System
            </p>
        </section>

        <section class="flex items-center justify-center px-6 py-10 lg:px-8">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center lg:hidden">
                    <a href="{{ url('/') }}" class="inline-flex justify-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white p-2 shadow-lg">
                            <img src="{{ asset('images/dgw-logo.png') }}"
                                 alt="DGW Logo"
                                 class="h-full w-full object-contain">
                        </div>
                    </a>

                    <h1 class="mt-4 text-2xl font-bold text-white">
                        DGW Loyalty
                    </h1>
                    <p class="text-sm text-blue-100">
                        Smart Loyalty System
                    </p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-3 shadow-2xl backdrop-blur-xl">
                    <div class="rounded-[1.5rem] bg-white p-8 shadow-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
