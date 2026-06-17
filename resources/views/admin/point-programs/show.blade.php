<x-app-layout>
    <x-slot name="header">
        <<h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail Program Poin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Program Poin
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail program poin, periode aktif, status, dan aturan poin yang terhubung.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.point-programs.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-slate-500">Nama Program</p>
                        <p class="font-semibold">{{ $pointProgram->program_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Dibuat Oleh</p>
                        <p class="font-semibold">{{ $pointProgram->creator->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Mulai</p>
                        <p class="font-semibold">{{ $pointProgram->start_date }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Selesai</p>
                        <p class="font-semibold">{{ $pointProgram->end_date }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        @if ($pointProgram->status === 'active')
                            <span class="mt-1 inline-block rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                Active
                            </span>
                        @elseif ($pointProgram->status === 'expired')
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-slate-100 text-slate-700 rounded">
                                Expired
                            </span>
                        @else
                            <span class="mt-1 inline-block rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Jumlah Aturan Poin</p>
                        <p class="font-semibold">{{ $pointProgram->rules->count() }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-500">Deskripsi</p>
                        <p class="font-semibold">{{ $pointProgram->description ?? '-' }}</p>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.point-programs.edit', $pointProgram) }}"
                       class="rounded-xl bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600">
                        Edit Program
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Daftar Aturan Poin</h3>
                </div>

                <table class="min-w-[900px] w-full text-left text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Jenis Transaksi</th>
                        <th class="px-4 py-3">Penerima Poin</th>
                        <th class="px-4 py-3">Poin / Item</th>
                        <th class="px-4 py-3">Min Qty</th>
                        <th class="px-4 py-3">Multiplier</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($pointProgram->rules as $rule)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-medium">
                                {{ $rule->product->product_name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($rule->transaction_type === 'customer_purchase')
                                    Konsumen beli di Toko/Kios
                                @else
                                    Toko/Kios beli ke DGW
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ $rule->recipient_type === 'customer' ? 'Konsumen' : 'Toko/Kios' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ number_format($rule->point_per_item) }}
                            </td>
                            <td class="px-4 py-3">
                                {{ number_format($rule->min_quantity) }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $rule->multiplier }}x
                            </td>
                            <td class="px-4 py-3">
                                @if ($rule->status === 'active')
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                            Active
                                        </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                            Inactive
                                        </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                                Belum ada aturan poin pada program ini.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
