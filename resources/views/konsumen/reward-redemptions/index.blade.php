<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Riwayat Penukaran Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Riwayat Penukaran Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Pantau daftar pengajuan reward, jumlah poin yang digunakan, dan status proses penukaran.
                    </p>
                </div>

                <x-ui.button href="{{ route('konsumen.rewards.index') }}">
                    Katalog Reward
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Reward</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Tanggal Pengajuan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($redemptions as $redemption)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $redemption->redemption_code }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $redemption->reward->reward_name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ number_format($redemption->points_used) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $redemption->redeemed_at ?? $redemption->created_at }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($redemption->status === 'completed')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                Completed
                                            </span>
                                    @elseif ($redemption->status === 'rejected')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                                Rejected
                                            </span>
                                    @elseif ($redemption->status === 'approved')
                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                Approved
                                            </span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                                Requested
                                            </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('konsumen.reward-redemptions.show', $redemption) }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                    Belum ada penukaran reward.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $redemptions->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
