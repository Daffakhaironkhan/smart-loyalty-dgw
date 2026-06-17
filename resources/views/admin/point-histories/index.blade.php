<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Riwayat Poin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Riwayat Poin
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail perubahan poin, sumber transaksi, jenis poin, dan waktu pencatatan dalam sistem.
                    </p>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[1100px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Sumber</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Saldo Setelah</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Dibuat Oleh</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($histories as $history)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $history->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $history->user->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    @if ($history->source_type === 'customer_transaction')
                                        Transaksi Konsumen
                                    @elseif ($history->source_type === 'store_purchase_transaction')
                                        Pembelian Toko/Kios
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

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($history->balance_after) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $history->description ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $history->creator->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500">
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
