<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Produk
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui nama, deskripsi, dan status kategori produk yang digunakan dalam sistem.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.products.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">

                @if ($errors->any())
                    <div class="mb-4 rounded-2xl bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kode Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kategori Produk
                            </label>
                            <select name="product_category_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tidak ada kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Poin Dasar Konsumen <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="base_customer_point" value="{{ old('base_customer_point', $product->base_customer_point) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                            <p class="text-xs text-slate-500 mt-1">
                                Poin yang diberikan kepada konsumen saat membeli produk di Toko/Kios.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Poin Dasar Toko/Kios <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="base_store_point" value="{{ old('base_store_point', $product->base_store_point) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                            <p class="text-xs text-slate-500 mt-1">
                                Poin yang diberikan kepada Toko/Kios saat membeli produk ke DGW.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="3"
                                      class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
