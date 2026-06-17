<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Edit Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui informasi reward, stok, kebutuhan poin, status, dan target pengguna yang dapat menukarkan.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.rewards.index') }}" variant="secondary">
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

                <form action="{{ route('admin.rewards.update', $reward) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kode Reward <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="reward_code" value="{{ old('reward_code', $reward->reward_code) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Reward <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="reward_name" value="{{ old('reward_name', $reward->reward_name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Poin Dibutuhkan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="required_points" value="{{ old('required_points', $reward->required_points) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" value="{{ old('stock', $reward->stock) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   min="0"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Bisa Ditukar Oleh <span class="text-red-500">*</span>
                            </label>
                            <select name="redeemable_by"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="customer" {{ old('redeemable_by', $reward->redeemable_by) === 'customer' ? 'selected' : '' }}>
                                    Konsumen
                                </option>
                                <option value="store" {{ old('redeemable_by', $reward->redeemable_by) === 'store' ? 'selected' : '' }}>
                                    Toko/Kios
                                </option>
                                <option value="both" {{ old('redeemable_by', $reward->redeemable_by) === 'both' ? 'selected' : '' }}>
                                    Konsumen & Toko/Kios
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="active" {{ old('status', $reward->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $reward->status) === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                <option value="out_of_stock" {{ old('status', $reward->status) === 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="3"
                                      class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $reward->description) }}</textarea>
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
