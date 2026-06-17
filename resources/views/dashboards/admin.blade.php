<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-8 text-white shadow-sm">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                            <span class="h-2 w-2 rounded-full bg-green-400"></span>
                            Smart Loyalty System
                        </div>

                        <h1 class="mt-5 text-3xl font-bold tracking-tight">
                            Dashboard Admin DGW Loyalty
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Pantau data Toko/Kios, Konsumen, Produk, transaksi pending, dan penukaran reward dalam satu dashboard terintegrasi.
                        </p>
                    </div>

                    <div class="flex h-20 w-28 items-center justify-center rounded-3xl bg-white p-3 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Toko/Kios
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($totalStores) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Mitra toko/kios yang terdaftar.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Konsumen
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($totalCustomers) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Member konsumen yang terdaftar.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        Total Produk
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-slate-900">
                        {{ number_format($totalProducts) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">
                        Produk aktif dalam sistem.
                    </p>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <a href="{{ route('admin.customer-transactions.index') }}"
                   class="block rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-medium text-slate-500">
                        Transaksi Konsumen Pending
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-orange-600">
                        {{ number_format($pendingCustomerTransactions) }}
                    </h3>
                    <p class="mt-3 text-xs text-slate-400">
                        Klik untuk melihat validasi transaksi konsumen.
                    </p>
                </a>

                <a href="{{ route('admin.store-purchases.index') }}"
                   class="block rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-medium text-slate-500">
                        Pembelian Toko Pending
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-orange-600">
                        {{ number_format($pendingStorePurchases) }}
                    </h3>
                    <p class="mt-3 text-xs text-slate-400">
                        Klik untuk melihat validasi pembelian toko.
                    </p>
                </a>

                <a href="{{ route('admin.reward-redemptions.index') }}"
                   class="block rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <p class="text-sm font-medium text-slate-500">
                        Reward Requested
                    </p>
                    <h3 class="mt-3 text-4xl font-bold text-orange-600">
                        {{ number_format($pendingRewardRedemptions) }}
                    </h3>
                    <p class="mt-3 text-xs text-slate-400">
                        Klik untuk melihat validasi penukaran reward.
                    </p>
                </a>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Quick Action
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Akses cepat untuk menambahkan data utama dalam sistem DGW Loyalty.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <a href="{{ route('admin.stores.create') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        + Tambah Toko/Kios
                    </a>

                    <a href="{{ route('admin.customers.create') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        + Tambah Konsumen
                    </a>

                    <a href="{{ route('admin.products.create') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        + Tambah Produk
                    </a>

                    <a href="{{ route('admin.rewards.create') }}"
                       class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        + Tambah Reward
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Transaksi Konsumen Terbaru
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar transaksi konsumen terbaru yang tercatat dalam sistem.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[640px] w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Toko</th>
                                <th class="px-4 py-3">Konsumen</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse ($recentCustomerTransactions as $transaction)
                                <tr class="border-t border-slate-100">
                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $transaction->transaction_code }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $transaction->store->store_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $transaction->customer->name ?? '-' }}
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
                            Pembelian Toko Terbaru
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Daftar pembelian Toko/Kios ke DGW terbaru yang tercatat.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-[640px] w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Toko</th>
                                <th class="px-4 py-3">Poin</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse ($recentStorePurchases as $purchase)
                                <tr class="border-t border-slate-100">
                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $purchase->transaction_code }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ $purchase->store->store_name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-700">
                                        {{ number_format($purchase->total_store_points) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($purchase->status === 'approved')
                                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                    Approved
                                                </span>
                                        @elseif ($purchase->status === 'rejected')
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
                                        Belum ada pembelian.
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
