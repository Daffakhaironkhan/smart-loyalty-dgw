<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Dashboard Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-8 text-white shadow-sm">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                            <span class="h-2 w-2 rounded-full bg-green-400"></span>
                            Konsumen Dashboard
                        </div>

                        <h1 class="mt-5 text-3xl font-bold tracking-tight">
                            Halo, {{ $customer->name }}
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Pantau total poin, riwayat transaksi, reward tersedia, dan status penukaran reward dalam satu dashboard.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                                {{ $customer->member_code }}
                            </span>

                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                                {{ ucfirst($customer->membership_level ?? 'Regular') }} Member
                            </span>
                        </div>
                    </div>

                    <div class="flex h-20 w-28 items-center justify-center rounded-3xl bg-white p-3 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Poin
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-blue-700">
                        {{ number_format($totalPoints) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Poin aktif yang bisa digunakan.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Transaksi
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($totalTransactions) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Transaksi pembelian tercatat.
                    </p>
                </div>

                <a href="{{ route('konsumen.reward-redemptions.index') }}"
                   class="block rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-medium text-slate-500">
                        Penukaran Reward
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($totalRewardRedemptions) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Riwayat pengajuan reward.
                    </p>
                </a>

                <a href="{{ route('konsumen.rewards.index') }}"
                   class="block rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-medium text-slate-500">
                        Reward Tersedia
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($availableRewards) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Reward yang dapat ditukar.
                    </p>
                </a>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Quick Access
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Akses cepat untuk melihat poin dan menukarkan reward.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <a href="{{ route('konsumen.point-histories.index') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        Lihat Riwayat Poin
                    </a>

                    <a href="{{ route('konsumen.rewards.index') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        Lihat Katalog Reward
                    </a>

                    <a href="{{ route('konsumen.reward-redemptions.index') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        Status Penukaran
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Transaksi Terbaru
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar transaksi pembelian terbaru yang tercatat untuk akun konsumen.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[640px] w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Toko/Kios</th>
                                <th class="px-4 py-3">Poin</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse ($recentTransactions as $transaction)
                                <tr class="border-t border-slate-100">
                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $transaction->transaction_code }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $transaction->store->store_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ number_format($transaction->total_customer_points) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($transaction->status === 'approved')
                                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                    Approved
                                                </span>
                                        @elseif ($transaction->status === 'rejected')
                                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                                    Rejected
                                                </span>
                                        @else
                                            <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                                    Pending
                                                </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Penukaran Reward Terbaru
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar pengajuan reward terbaru beserta status prosesnya.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[640px] w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Reward</th>
                                <th class="px-4 py-3">Poin</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse ($recentRewardRedemptions as $redemption)
                                <tr class="border-t border-slate-100">
                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $redemption->redemption_code }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $redemption->reward->reward_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ number_format($redemption->points_used) }}
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                                        Belum ada penukaran reward.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
