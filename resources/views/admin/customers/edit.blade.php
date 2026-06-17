<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Edit Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Edit Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui informasi konsumen, data kontak, status member, serta relasi Toko/Kios pendaftar.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.customers.index') }}" variant="secondary">
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

                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Kode Member
                            </label>
                            <input type="text" value="{{ $customer->member_code }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm bg-slate-100"
                                   disabled>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nama Konsumen <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Nomor Telepon
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Username
                            </label>
                            <input type="text" name="username" value="{{ old('username', $customer->user->username ?? '') }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                                Tanggal Lahir
                            </label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Gender
                            </label>
                            <select name="gender"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Gender</option>
                                <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                                <option value="other" {{ old('gender', $customer->gender) === 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Membership Level
                            </label>
                            <input type="text" name="membership_level" value="{{ old('membership_level', $customer->membership_level) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Toko/Kios Pendaftar
                            </label>
                            <select name="registered_by_store_id"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tidak ada</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}" {{ old('registered_by_store_id', $customer->registered_by_store_id) == $store->id ? 'selected' : '' }}>
                                        {{ $store->store_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Alamat
                            </label>
                            <textarea name="address" rows="3"
                                      class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', $customer->address) }}</textarea>
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
