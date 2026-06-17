<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Konfirmasi Password
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Area ini membutuhkan verifikasi ulang. Masukkan password akun kamu untuk melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="password"
                          name="password"
                          required
                          autocomplete="current-password"
                          placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Konfirmasi
        </button>

        <div class="text-center">
            <a href="{{ url('/') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Kembali ke halaman utama
            </a>
        </div>
    </form>
</x-guest-layout>
