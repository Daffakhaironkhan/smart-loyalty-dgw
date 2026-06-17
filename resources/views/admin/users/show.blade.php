<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail User
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail User
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail akun pengguna, role, status, dan relasi data yang terhubung.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.users.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-slate-500">Nama</p>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Phone</p>
                        <p class="font-semibold">{{ $user->phone ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Username</p>
                        <p class="font-semibold">{{ $user->username ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Role</p>
                        <p class="font-semibold">
                            {{ $user->roles->pluck('name')->join(', ') ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        @if ($user->status === 'active')
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Active
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Inactive
                            </span>
                        @endif
                    </div>

                    @if ($user->store)
                        <div>
                            <p class="text-sm text-slate-500">Data Toko/Kios</p>
                            <p class="font-semibold">
                                {{ $user->store->store_name }} — {{ $user->store->store_code }}
                            </p>
                        </div>
                    @endif

                    @if ($user->customer)
                        <div>
                            <p class="text-sm text-slate-500">Data Konsumen</p>
                            <p class="font-semibold">
                                {{ $user->customer->name }} — {{ $user->customer->member_code }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-slate-500">Dibuat Pada</p>
                        <p class="font-semibold">
                            {{ $user->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="rounded-xl bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600">
                        Edit User
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
