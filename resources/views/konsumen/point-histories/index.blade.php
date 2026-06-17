<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Riwayat Poin Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Riwayat Poin Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat seluruh perubahan poin dari transaksi pembelian, penukaran reward, dan penyesuaian sistem.
                    </p>
                </div>

                <x-ui.button href="{{ route('konsumen.rewards.index') }}">
                    Lihat Katalog Reward
                </x-ui.button>
            </div>

            <div class="mb-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-6 text-white shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-blue-100">
                            Total Poin Saat Ini
                        </p>
                        <h3 class="mt-2 text-4xl font-bold">
                            {{ number_format(auth()->user()->customer->total_points ?? 0) }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-300">
                            Poin aktif yang dapat digunakan untuk penukaran reward.
                        </p>
                    </div>

                    <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-white p-2 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Daftar Riwayat Poin
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Riwayat masuk dan keluar poin berdasarkan aktivitas akun konsumen.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[980px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Sumber</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Saldo Setelah</th>
                            <th class="px-4 py-3">Keterangan</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($histories as $history)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $history->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    @if ($history->source_type === 'customer_transaction')
                                        Transaksi Pembelian
                                    @elseif ($history->source_type === 'reward_redemption')
                                        Penukaran Reward
                                    @else
                                        Penyesuaian Manual
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    @if ($history->point_type === 'in')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                Masuk
                                            </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                                Keluar
                                            </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 font-semibold {{ $history->point_type === 'in' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $history->point_type === 'in' ? '+' : '-' }}{{ number_format($history->points) }}
                                </td>

                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ number_format($history->balance_after) }}
                                </td>

                                <td class="px-4 py-3 text-slate-600">
                                    {{ $history->description ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                    Belum ada riwayat poin.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $histories->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
