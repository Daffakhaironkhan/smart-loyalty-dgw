<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Buat Akun DGW Loyalty
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Daftarkan akun baru untuk mulai menggunakan Smart Loyalty System.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nama" />

            <x-text-input id="name"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="text"
                          name="name"
                          :value="old('name')"
                          required
                          autofocus
                          autocomplete="name"
                          placeholder="Masukkan nama lengkap" />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />

            <x-text-input id="email"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autocomplete="username"
                          placeholder="Masukkan email akun" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />

            <x-text-input id="password"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="password"
                          name="password"
                          required
                          autocomplete="new-password"
                          placeholder="Masukkan password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />

            <x-text-input id="password_confirmation"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="password"
                          name="password_confirmation"
                          required
                          autocomplete="new-password"
                          placeholder="Ulangi password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Daftar Akun
        </button>

        <div class="flex items-center justify-center gap-2 text-sm">
            <span class="text-gray-500">
                Sudah punya akun?
            </span>

            <a href="{{ route('login') }}"
               class="font-semibold text-blue-600 hover:text-blue-700">
                Masuk
            </a>
        </div>

        <div class="text-center">
            <a href="{{ url('/') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Kembali ke halaman utama
            </a>
        </div>
    </form>

    <div class="mt-8 rounded-2xl bg-amber-50 p-4">
        <p class="text-sm font-semibold text-amber-900">
            Catatan
        </p>

        <p class="mt-2 text-sm leading-6 text-amber-800">
            Akun yang dibuat melalui halaman register akan mengikuti pengaturan default sistem. Untuk role khusus seperti Admin, Toko/Kios, atau Konsumen, data dapat disesuaikan oleh Admin melalui dashboard.
        </p>
    </div>
</x-guest-layout>
