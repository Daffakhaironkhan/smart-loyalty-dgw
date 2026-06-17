<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Edit Toko/Kios
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Toko/Kios
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui informasi Toko/Kios, data pemilik, wilayah, status, dan akun pengguna yang terhubung.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.stores.index') }}" variant="secondary">
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

                <form action="{{ route('admin.stores.update', $store) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kode Toko/Kios
                            </label>
                            <input type="text" value="{{ $store->store_code }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm bg-slate-100"
                                   disabled>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Toko/Kios <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="store_name" value="{{ old('store_name', $store->store_name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Pemilik
                            </label>
                            <input type="text" name="owner_name" value="{{ old('owner_name', $store->owner_name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $store->email) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nomor Telepon
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $store->phone) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" value="{{ old('username', $store->user->username) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Password Baru
                            </label>
                            <input type="password" name="password"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-slate-500 mt-1">
                                Kosongkan jika tidak ingin mengubah password.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kota
                            </label>
                            <input type="text" name="city" value="{{ old('city', $store->city) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Area/Wilayah
                            </label>
                            <input type="text" name="area" value="{{ old('area', $store->area) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="active" {{ old('status', $store->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $store->status) === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Alamat
                            </label>
                            <textarea name="address" rows="3"
                                      class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $store->address) }}</textarea>
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
