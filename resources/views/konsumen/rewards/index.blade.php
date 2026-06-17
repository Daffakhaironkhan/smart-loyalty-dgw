<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Katalog Reward Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Katalog Reward Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Pilih reward yang tersedia dan ajukan penukaran menggunakan poin aktif akun konsumen.
                    </p>
                </div>

                <x-ui.button href="{{ route('konsumen.reward-redemptions.index') }}" variant="secondary">
                    Riwayat Penukaran
                </x-ui.button>
            </div>

            @if (session('error'))
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-6 text-white shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Total Poin Konsumen Saat Ini</p>
                        <h3 class="mt-2 text-4xl font-bold">
                            {{ number_format(auth()->user()->customer->total_points ?? 0) }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-300">
                            Gunakan poin untuk mengajukan penukaran reward yang tersedia.
                        </p>
                    </div>

                    <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-white p-2 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @forelse ($rewards as $reward)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <p class="text-sm font-medium text-slate-500">
                                {{ $reward->reward_code }}
                            </p>

                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                Reward
                            </span>
                        </div>

                        <h3 class="mt-2 text-lg font-bold text-slate-900">
                            {{ $reward->reward_name }}
                        </h3>

                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">
                            {{ $reward->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-4 rounded-2xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs text-slate-500">Poin Dibutuhkan</p>
                                <p class="mt-1 text-lg font-bold text-blue-700">
                                    {{ number_format($reward->required_points) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Stok</p>
                                <p class="mt-1 text-lg font-bold text-slate-900">
                                    {{ number_format($reward->stock) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="{{ route('konsumen.rewards.show', $reward) }}"
                               class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                Detail Reward
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-slate-500 md:col-span-3">
                        Belum ada reward yang tersedia untuk Konsumen.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $rewards->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
