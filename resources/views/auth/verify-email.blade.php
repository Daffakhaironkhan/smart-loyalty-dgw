<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex justify-center">
            <img src="{{ asset('images/dgw-logo.png') }}"
                 alt="DGW Logo"
                 class="h-14 w-auto object-contain">
        </a>

        <h1 class="mt-6 text-2xl font-bold text-gray-900">
            Verifikasi Email
        </h1>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Sebelum melanjutkan, silakan verifikasi email melalui link yang sudah dikirimkan ke alamat email kamu.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 rounded-2xl bg-green-50 p-4 text-sm font-medium text-green-700">
            Link verifikasi baru sudah dikirimkan ke email yang terdaftar.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                Logout
            </button>
        </form>
    </div>

    <div class="mt-8 rounded-2xl bg-blue-50 p-4">
        <p class="text-sm font-semibold text-blue-900">
            Informasi
        </p>
        <p class="mt-2 text-sm leading-6 text-blue-800">
            Jika email belum masuk, periksa folder spam atau hubungi Admin untuk bantuan aktivasi akun.
        </p>
    </div>
</x-guest-layout>
