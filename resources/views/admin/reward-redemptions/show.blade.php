<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Penukaran Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Penukaran Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail pengajuan penukaran reward, pengguna yang mengajukan, poin yang digunakan, dan status proses validasi.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.reward-redemptions.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">
                            Informasi Penukaran
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Ringkasan data pengajuan dan status penukaran reward.
                        </p>
                    </div>

                    <div>
                        @if ($rewardRedemption->status === 'completed')
                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                Completed
                            </span>
                        @elseif ($rewardRedemption->status === 'rejected')
                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                Rejected
                            </span>
                        @elseif ($rewardRedemption->status === 'approved')
                            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                Approved
                            </span>
                        @elseif ($rewardRedemption->status === 'processed')
                            <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700">
                                Processed
                            </span>
                        @else
                            <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                Requested
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Kode Penukaran</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $rewardRedemption->redemption_code }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Pengajuan</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $rewardRedemption->redeemed_at ?? $rewardRedemption->created_at }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Nama User</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $rewardRedemption->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Role</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            @if ($rewardRedemption->user?->hasRole('toko_kios'))
                                Toko/Kios
                            @elseif ($rewardRedemption->user?->hasRole('konsumen'))
                                Konsumen
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    @if ($rewardRedemption->user?->store)
                        <div>
                            <p class="text-sm text-slate-500">Nama Toko/Kios</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $rewardRedemption->user->store->store_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Poin Toko/Kios Saat Ini</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ number_format($rewardRedemption->user->store->total_points) }}
                            </p>
                        </div>
                    @endif

                    @if ($rewardRedemption->user?->customer)
                        <div>
                            <p class="text-sm text-slate-500">Nama Konsumen</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $rewardRedemption->user->customer->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Poin Konsumen Saat Ini</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ number_format($rewardRedemption->user->customer->total_points) }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-slate-500">Reward</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $rewardRedemption->reward->reward_name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poin Digunakan</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ number_format($rewardRedemption->points_used) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Stok Reward Saat Ini</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ number_format($rewardRedemption->reward->stock ?? 0) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Diproses Oleh</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $rewardRedemption->processor->name ?? '-' }}
                        </p>
                    </div>

                    @if ($rewardRedemption->processed_at)
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Diproses</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $rewardRedemption->processed_at }}
                            </p>
                        </div>
                    @endif

                    @if ($rewardRedemption->completed_at)
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Selesai</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $rewardRedemption->completed_at }}
                            </p>
                        </div>
                    @endif

                    @if ($rewardRedemption->rejection_reason)
                        <div class="md:col-span-2">
                            <p class="text-sm text-slate-500">Alasan Penolakan</p>
                            <p class="mt-1 font-semibold text-red-600">
                                {{ $rewardRedemption->rejection_reason }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @if (in_array($rewardRedemption->status, ['requested', 'approved']))
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-semibold text-slate-900">
                            Aksi Validasi
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Tinjau pengajuan reward sebelum disetujui, diselesaikan, atau ditolak oleh Admin.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-3 md:flex-row">
                            @if ($rewardRedemption->status === 'requested')
                                <form action="{{ route('admin.reward-redemptions.approve', $rewardRedemption) }}"
                                      method="POST"
                                      onsubmit="return confirm('Setujui pengajuan penukaran reward ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <x-ui.button type="submit">
                                        Approve Pengajuan
                                    </x-ui.button>
                                </form>
                            @endif

                            @if ($rewardRedemption->status === 'approved')
                                <form action="{{ route('admin.reward-redemptions.complete', $rewardRedemption) }}"
                                      method="POST"
                                      onsubmit="return confirm('Selesaikan penukaran ini? Poin dan stok akan langsung dikurangi.')">
                                    @csrf
                                    @method('PATCH')

                                    <x-ui.button type="submit" variant="success">
                                        Complete Penukaran
                                    </x-ui.button>
                                </form>
                            @endif
                        </div>

                        <form action="{{ route('admin.reward-redemptions.reject', $rewardRedemption) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="flex flex-col gap-3 md:flex-row">
                                <input type="text"
                                       name="rejection_reason"
                                       placeholder="Alasan penolakan"
                                       class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>

                                <x-ui.button
                                    type="submit"
                                    variant="danger"
                                    onclick="return confirm('Tolak pengajuan penukaran reward ini?')">
                                    Reject Pengajuan
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
