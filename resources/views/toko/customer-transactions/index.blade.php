<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">Transaksi Konsumen</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Transaksi Konsumen</h1>
                    <p class="mt-1 text-sm text-slate-500">Kelola transaksi pembelian konsumen yang dicatat oleh Toko/Kios.</p>
                </div>

                <a href="{{ route('toko.customer-transactions.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    + Tambah Transaksi
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-2xl bg-green-50 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[950px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Konsumen</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($transactions as $transaction)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $transaction->transaction_code }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $transaction->transaction_date }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $transaction->customer->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format($transaction->total_customer_points) }}</td>
                                <td class="px-4 py-3">
                                    @if ($transaction->status === 'approved')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">Approved</span>
                                    @elseif ($transaction->status === 'rejected')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Rejected</span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('toko.customer-transactions.show', $transaction) }}" class="inline-flex rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi konsumen.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">{{ $transactions->links() }}</div>
        </div>
    </div>
</x-app-layout>
