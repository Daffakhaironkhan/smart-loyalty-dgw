<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Lupa Password?
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Masukkan email akun kamu. Sistem akan mengirimkan link reset password untuk membuat password baru.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                          placeholder="Masukkan email akun" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Kirim Link Reset Password
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}"
               class="text-sm font-medium text-gray-500 hover:text-gray-700">
                Kembali ke halaman login
            </a>
        </div>
    </form>

    <div class="mt-8 rounded-2xl bg-blue-50 p-4">
        <p class="text-sm font-semibold text-blue-900">
            Informasi
        </p>

        <p class="mt-2 text-sm leading-6 text-blue-800">
            Pastikan email yang dimasukkan sudah terdaftar dalam sistem DGW Loyalty agar link reset password dapat dikirimkan.
        </p>
    </div>
</x-guest-layout>
