<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-8 text-white shadow-sm">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                            <span class="h-2 w-2 rounded-full bg-green-400"></span>
                            Smart Loyalty System
                        </div>

                        <h1 class="mt-5 text-3xl font-bold tracking-tight">
                            Selamat datang di DGW Loyalty
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Sistem loyalty untuk mengelola transaksi, poin, reward, validasi, dan laporan dalam satu platform terintegrasi.
                        </p>
                    </div>

                    <div class="flex h-20 w-28 items-center justify-center rounded-3xl bg-white p-3 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
