<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Produk
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Produk
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola produk DGW, kategori, harga, stok, dan poin untuk konsumen maupun Toko/Kios.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.products.create') }}">
                    + Tambah Produk
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.products.index') }}">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:items-end">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Cari
                            </label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode produk, nama produk, kategori..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kategori
                            </label>
                            <select name="category_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">
                                Filter
                            </x-ui.button>

                            <x-ui.button href="{{ route('admin.products.index') }}" variant="secondary">
                                Reset
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Poin Konsumen</th>
                            <th class="px-4 py-3">Poin Toko/Kios</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($products as $product)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $product->product_code }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $product->product_name }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $product->category->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($product->base_customer_point) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($product->base_store_point) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($product->stock) }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($product->status === 'active')
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
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                           class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-200">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="rounded-xl bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-xl bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
