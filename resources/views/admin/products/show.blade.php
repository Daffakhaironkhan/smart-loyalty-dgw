<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Produk
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail produk, kategori, harga, stok, dan poin yang diberikan untuk setiap jenis transaksi.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.products.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-slate-500">Kode Produk</p>
                        <p class="font-semibold">{{ $product->product_code }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Nama Produk</p>
                        <p class="font-semibold">{{ $product->product_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Kategori</p>
                        <p class="font-semibold">{{ $product->category->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Harga</p>
                        <p class="font-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poin Dasar Konsumen</p>
                        <p class="font-semibold">
                            {{ number_format($product->base_customer_point) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poin Dasar Toko/Kios</p>
                        <p class="font-semibold">
                            {{ number_format($product->base_store_point) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Stok</p>
                        <p class="font-semibold">
                            {{ number_format($product->stock) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        @if ($product->status === 'active')
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Active
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-500">Deskripsi</p>
                        <p class="font-semibold">
                            {{ $product->description ?? '-' }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="rounded-xl bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600">
                        Edit Produk
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
