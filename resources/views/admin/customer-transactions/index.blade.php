<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Validasi Transaksi Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Validasi Transaksi Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Tinjau transaksi pembelian Konsumen sebelum disetujui atau ditolak oleh Admin.
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.customer-transactions.index') }}">
                    <div class="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Cari</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode transaksi, nama toko, nama konsumen..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">Filter</x-ui.button>
                            <x-ui.button href="{{ route('admin.customer-transactions.index') }}" variant="secondary">Reset</x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[1000px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Toko/Kios</th>
                            <th class="px-4 py-3">Konsumen</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($customerTransactions as $transaction)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">{{ $transaction->transaction_code }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $transaction->transaction_date }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $transaction->store->store_name ?? '-' }}</td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $transaction->customer->name ?? '-' }}</td>
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
                                    <a href="{{ route('admin.customer-transactions.show', $transaction) }}"
                                       class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                                    Belum ada transaksi konsumen.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $customerTransactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
