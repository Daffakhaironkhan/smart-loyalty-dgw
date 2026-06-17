<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Masuk ke DGW Loyalty
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Gunakan akun Admin, Toko/Kios, atau Konsumen untuk mengakses Smart Loyalty System.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email"
                          class="mt-1 block w-full rounded-xl border-gray-300"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
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
                          autocomplete="current-password"
                          placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                       name="remember">

                <span class="ms-2 text-sm text-gray-600">
                    Ingat saya
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 hover:text-blue-700"
                   href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Masuk ke Sistem
        </button>

        <div class="flex items-center justify-center gap-2 text-sm">
            <span class="text-gray-500">
                Belum punya akun?
            </span>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="font-semibold text-blue-600 hover:text-blue-700">
                    Daftar
                </a>
            @endif
        </div>

        <div class="text-center">
            <a href="{{ url('/') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Kembali ke halaman utama
            </a>
        </div>
    </form>

    <div class="mt-8 rounded-2xl bg-blue-50 p-4">
        <p class="text-sm font-semibold text-blue-900">
            Akun demo
        </p>

        <div class="mt-3 space-y-2 text-sm text-blue-800">
            <p>
                <span class="font-semibold">Admin:</span>
                admin@dgw.test
            </p>
            <p>
                <span class="font-semibold">Toko/Kios:</span>
                toko@dgw.test
            </p>
            <p>
                <span class="font-semibold">Konsumen:</span>
                konsumen@dgw.test
            </p>
            <p class="pt-1 text-xs text-blue-700">
                Password demo: <span class="font-semibold">password</span>
            </p>
        </div>
    </div>
</x-guest-layout>
