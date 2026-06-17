<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Edit Aturan Poin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Aturan Poin
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui aturan poin, produk terkait, minimum kuantitas, multiplier, dan status aturan.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.point-rules.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.point-rules.update', $pointRule) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Program Poin <span class="text-red-500">*</span>
                            </label>
                            <select name="point_program_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Pilih Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('point_program_id', $pointRule->point_program_id) == $program->id ? 'selected' : '' }}>
                                        {{ $program->program_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $pointRule->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->product_code }} - {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Jenis Transaksi <span class="text-red-500">*</span>
                            </label>
                            <select name="transaction_type"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="customer_purchase" {{ old('transaction_type', $pointRule->transaction_type) === 'customer_purchase' ? 'selected' : '' }}>
                                    Konsumen beli di Toko/Kios
                                </option>
                                <option value="store_purchase" {{ old('transaction_type', $pointRule->transaction_type) === 'store_purchase' ? 'selected' : '' }}>
                                    Toko/Kios beli ke DGW
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Penerima Poin <span class="text-red-500">*</span>
                            </label>
                            <select name="recipient_type"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Pilih Penerima</option>
                                <option value="customer" {{ old('recipient_type', $pointRule->recipient_type) === 'customer' ? 'selected' : '' }}>
                                    Konsumen
                                </option>
                                <option value="store" {{ old('recipient_type', $pointRule->recipient_type) === 'store' ? 'selected' : '' }}>
                                    Toko/Kios
                                </option>
                            </select>
                            <p class="text-xs text-slate-500 mt-1">
                                Jika transaksi konsumen, penerima harus Konsumen. Jika pembelian Toko/Kios ke DGW, penerima harus Toko/Kios.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Poin per Item <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="point_per_item" value="{{ old('point_per_item', $pointRule->point_per_item) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Minimal Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="min_quantity" value="{{ old('min_quantity', $pointRule->min_quantity) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="1"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Multiplier <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="multiplier" value="{{ old('multiplier', $pointRule->multiplier) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   step="0.01"
                                   min="0"
                                   required>
                            <p class="text-xs text-slate-500 mt-1">
                                Contoh: 1 berarti normal, 2 berarti poin dikalikan dua.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="active" {{ old('status', $pointRule->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $pointRule->status) === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
