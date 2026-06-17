<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Reset Password
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Buat password baru untuk mengamankan kembali akses akun DGW Loyalty kamu.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="email"
                          name="email"
                          :value="old('email', $request->email)"
                          required
                          autofocus
                          autocomplete="username"
                          placeholder="Masukkan email akun" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="password"
                          name="password"
                          required
                          autocomplete="new-password"
                          placeholder="Masukkan password baru" />
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
                          placeholder="Ulangi password baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Simpan Password Baru
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Kembali ke halaman login
            </a>
        </div>
    </form>
</x-guest-layout>
