<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Profile Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-3xl bg-gradient-to-br from-blue-950 via-slate-950 to-indigo-950 p-8 text-white shadow-sm">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm text-blue-100">
                            <span class="h-2 w-2 rounded-full bg-green-400"></span>
                            Account Settings
                        </div>

                        <h1 class="mt-5 text-3xl font-bold tracking-tight">
                            Kelola Profile Akun
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">
                            Perbarui informasi akun, email, username, nomor telepon, dan password untuk menjaga keamanan akses DGW Loyalty.
                        </p>
                    </div>

                    <div class="flex h-20 w-28 items-center justify-center rounded-3xl bg-white p-3 shadow-lg">
                        <img src="{{ asset('images/dgw-logo.png') }}"
                             alt="DGW Logo"
                             class="h-full w-full object-contain">
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <p class="font-semibold">Terjadi kesalahan:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Informasi Akun
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Perbarui data dasar akun yang digunakan untuk login dan identitas dalam sistem.
                        </p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Nama</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Phone</label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Username</label>
                            <input type="text"
                                   name="username"
                                   value="{{ old('username', $user->username) }}"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Role</label>
                                <input type="text"
                                       value="{{ $user->roles->pluck('name')->join(', ') ?: '-' }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 bg-slate-50 text-slate-500 shadow-sm"
                                       disabled>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Status</label>
                                <input type="text"
                                       value="{{ ucfirst($user->status) }}"
                                       class="mt-1 w-full rounded-xl border-slate-300 bg-slate-50 text-slate-500 shadow-sm"
                                       disabled>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Simpan Profile
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Ubah Password
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Gunakan password baru yang kuat untuk menjaga keamanan akun.
                        </p>
                    </div>

                    <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Password Lama</label>
                            <input type="password"
                                   name="current_password"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Konfirmasi Password Baru</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div class="rounded-2xl bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                            Pastikan password baru tidak sama dengan password lama dan mudah diingat oleh pemilik akun.
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
