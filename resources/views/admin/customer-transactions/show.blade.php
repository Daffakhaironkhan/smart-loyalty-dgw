<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Transaksi Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Transaksi Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail transaksi pembelian Konsumen, produk yang dibeli, total poin, dan status validasi transaksi.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.customer-transactions.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">
                            Informasi Transaksi
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Ringkasan data transaksi, konsumen, toko, total pembelian, dan status validasi.
                        </p>
                    </div>

                    <div>
                        @if ($customerTransaction->status === 'approved')
                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                Approved
                            </span>
                        @elseif ($customerTransaction->status === 'rejected')
                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                Rejected
                            </span>
                        @else
                            <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                Pending
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Kode Transaksi</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $customerTransaction->transaction_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Transaksi</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $customerTransaction->transaction_date }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Toko/Kios</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $customerTransaction->store->store_name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Konsumen</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $customerTransaction->customer->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Total Transaksi</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            Rp {{ number_format($customerTransaction->total_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Total Poin Konsumen</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ number_format($customerTransaction->total_customer_points) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Diproses Oleh</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $customerTransaction->approver->name ?? '-' }}
                        </p>
                    </div>

                    @if ($customerTransaction->approved_at)
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Diproses</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $customerTransaction->approved_at }}
                            </p>
                        </div>
                    @endif

                    @if ($customerTransaction->rejection_reason)
                        <div class="md:col-span-2">
                            <p class="text-sm text-slate-500">Alasan Penolakan</p>
                            <p class="mt-1 font-semibold text-red-600">
                                {{ $customerTransaction->rejection_reason }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Detail Produk
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Daftar produk yang tercatat dalam transaksi beserta harga, subtotal, dan poin yang diperoleh.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Subtotal</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Aturan Poin</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($customerTransaction->items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $item->product->product_name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($item->quantity) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($item->customer_points) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    @if ($item->pointRule)
                                        {{ $item->pointRule->point_per_item }} poin/item,
                                        min {{ $item->pointRule->min_quantity }},
                                        {{ $item->pointRule->multiplier }}x
                                    @else
                                        Poin dasar produk
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($customerTransaction->status === 'pending')
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Aksi Validasi
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Tinjau transaksi Konsumen sebelum disetujui atau ditolak oleh Admin.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">
                        <form action="{{ route('admin.customer-transactions.approve', $customerTransaction) }}"
                              method="POST"
                              onsubmit="return confirm('Setujui transaksi ini dan tambahkan poin ke konsumen?')">
                            @csrf
                            @method('PATCH')

                            <x-ui.button type="submit" variant="success">
                                Approve Transaksi
                            </x-ui.button>
                        </form>

                        <form action="{{ route('admin.customer-transactions.reject', $customerTransaction) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="flex flex-col gap-3 md:flex-row">
                                <input type="text"
                                       name="rejection_reason"
                                       placeholder="Alasan penolakan"
                                       class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>

                                <x-ui.button
                                    type="submit"
                                    variant="danger"
                                    onclick="return confirm('Tolak transaksi ini?')">
                                    Reject Transaksi
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
