<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Laporan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    Laporan Sistem
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau transaksi Konsumen, pembelian Toko/Kios, penukaran reward, dan pergerakan poin dalam sistem.
                </p>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.reports.index') }}">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:items-end">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Tanggal Mulai
                            </label>
                            <input type="date"
                                   name="start_date"
                                   value="{{ $startDate }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Tanggal Selesai
                            </label>
                            <input type="date"
                                   name="end_date"
                                   value="{{ $endDate }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2 flex gap-2">
                            <x-ui.button type="submit">
                                Filter
                            </x-ui.button>

                            <x-ui.button href="{{ route('admin.reports.index') }}" variant="secondary">
                                Reset
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">
                            Export Laporan
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Unduh data laporan berdasarkan periode tanggal yang sedang dipilih.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-ui.button
                            href="{{ route('admin.reports.export.customer-transactions', [
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ]) }}"
                            variant="success">
                            Transaksi Konsumen
                        </x-ui.button>

                        <x-ui.button
                            href="{{ route('admin.reports.export.store-purchases', [
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ]) }}"
                            variant="success">
                            Pembelian Toko
                        </x-ui.button>

                        <x-ui.button
                            href="{{ route('admin.reports.export.reward-redemptions', [
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ]) }}"
                            variant="success">
                            Penukaran Reward
                        </x-ui.button>
                    </div>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Transaksi Konsumen</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($summary['customer_transaction_count']) }}
                    </h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Rp {{ number_format($summary['customer_transaction_amount'], 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-slate-500">
                        {{ number_format($summary['customer_transaction_points']) }} poin
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Pembelian Toko</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($summary['store_purchase_count']) }}
                    </h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Rp {{ number_format($summary['store_purchase_amount'], 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-slate-500">
                        {{ number_format($summary['store_purchase_points']) }} poin
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Penukaran Reward</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($summary['reward_redemption_count']) }}
                    </h3>
                    <p class="mt-2 text-sm text-slate-500">
                        {{ number_format($summary['reward_redemption_points']) }} poin digunakan
                    </p>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Poin Masuk</p>
                    <h3 class="mt-2 text-3xl font-bold text-green-600">
                        +{{ number_format($summary['point_in']) }}
                    </h3>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Total Poin Keluar</p>
                    <h3 class="mt-2 text-3xl font-bold text-red-600">
                        -{{ number_format($summary['point_out']) }}
                    </h3>
                </div>
            </div>

            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Transaksi Konsumen Terbaru
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Daftar transaksi Konsumen terbaru dalam periode laporan.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[950px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Toko/Kios</th>
                            <th class="px-4 py-3">Konsumen</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($recentCustomerTransactions as $transaction)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $transaction->transaction_code }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $transaction->transaction_date }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $transaction->store->store_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $transaction->customer->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
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
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada transaksi konsumen.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Pembelian Toko/Kios Terbaru
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Daftar pembelian Toko/Kios ke DGW terbaru dalam periode laporan.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[950px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Toko/Kios</th>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($recentStorePurchases as $purchase)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $purchase->transaction_code }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $purchase->transaction_date }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $purchase->store->store_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $purchase->invoice_number ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
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
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada pembelian toko.
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
                        Daftar pengajuan penukaran reward terbaru dalam periode laporan.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[800px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Reward</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($recentRewardRedemptions as $redemption)
                            <tr class="border-t">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $redemption->redemption_code }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $redemption->user->name ?? '-' }}
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
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">
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
</x-app-layout>
