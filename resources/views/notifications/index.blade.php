<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifikasi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Notifikasi
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Lihat informasi terbaru terkait transaksi, validasi, penukaran reward, dan aktivitas penting dalam sistem.
                    </p>
                </div>

                <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <x-ui.button type="submit">
                        Tandai Semua Dibaca
                    </x-ui.button>
                </form>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Daftar Notifikasi
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Notifikasi yang belum dibaca akan ditandai dengan label baru.
                    </p>
                </div>

                @forelse ($notifications as $notification)
                    <a href="{{ route('notifications.show', $notification) }}"
                       class="block border-b border-gray-100 px-6 py-4 transition hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50/70' }}">

                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $notification->title }}
                                    </h3>

                                    @if (!$notification->read_at)
                                        <span class="rounded-full bg-blue-600 px-2.5 py-1 text-xs font-medium text-white">
                                            Baru
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    {{ $notification->message }}
                                </p>

                                <p class="mt-2 text-xs text-gray-400">
                                    {{ $notification->created_at->format('d M Y H:i') }}
                                </p>
                            </div>

                            <div class="shrink-0 pt-1 text-gray-400">
                                →
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-10 text-center">
                        <p class="text-sm font-medium text-gray-700">
                            Belum ada notifikasi.
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Notifikasi terkait transaksi, validasi, dan reward akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
