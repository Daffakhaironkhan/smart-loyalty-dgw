<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Aturan Poin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Aturan Poin
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola aturan perhitungan poin berdasarkan program, produk, jenis transaksi, dan penerima poin.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.point-rules.create') }}">
                    + Tambah Aturan
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Program</th>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Jenis Transaksi</th>
                            <th class="px-4 py-3">Penerima</th>
                            <th class="px-4 py-3">Poin / Item</th>
                            <th class="px-4 py-3">Min Qty</th>
                            <th class="px-4 py-3">Multiplier</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($rules as $rule)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $rule->program->program_name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $rule->product->product_name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    @if ($rule->transaction_type === 'customer_purchase')
                                        Konsumen beli di Toko/Kios
                                    @else
                                        Toko/Kios beli ke DGW
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $rule->recipient_type === 'customer' ? 'Konsumen' : 'Toko/Kios' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($rule->point_per_item) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($rule->min_quantity) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
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

                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.point-rules.edit', $rule) }}"
                                           class="rounded-lg bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.point-rules.destroy', $rule) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus aturan poin ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data aturan poin.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $rules->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
