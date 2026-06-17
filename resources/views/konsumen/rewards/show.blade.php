<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail reward, kebutuhan poin, stok, dan ajukan penukaran jika poin mencukupi.
                    </p>
                </div>

                <x-ui.button href="{{ route('konsumen.rewards.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>

            @if (session('error'))
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-6 text-white">
                    <p class="text-sm text-blue-100">
                        {{ $reward->reward_code }}
                    </p>
                    <h3 class="mt-2 text-2xl font-bold">
                        {{ $reward->reward_name }}
                    </h3>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                        {{ $reward->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                    <div class="rounded-2xl bg-blue-50 p-4">
                        <p class="text-sm text-blue-700">Poin Dibutuhkan</p>
                        <p class="mt-1 text-3xl font-bold text-blue-700">
                            {{ number_format($reward->required_points) }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Poin Konsumen Saat Ini</p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">
                            {{ number_format(auth()->user()->customer->total_points ?? 0) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Stok</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ number_format($reward->stock) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Bisa Ditukar Oleh</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $reward->redeemable_by === 'both' ? 'Konsumen & Toko/Kios' : 'Konsumen' }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-500">Deskripsi</p>
                        <p class="mt-1 leading-6 text-slate-700">{{ $reward->description ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-100 px-6 py-5">
                    <form action="{{ route('konsumen.rewards.redeem', $reward) }}"
                          method="POST"
                          onsubmit="return confirm('Ajukan penukaran reward ini?')">
                        @csrf

                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Ajukan Penukaran
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
