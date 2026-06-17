<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail Penukaran Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Penukaran Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail pengajuan reward, poin yang digunakan, dan status proses penukaran.
                    </p>
                </div>

                <x-ui.button href="{{ route('konsumen.reward-redemptions.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Kode Penukaran</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">
                            {{ $rewardRedemption->redemption_code }}
                        </h3>
                    </div>

                    <div>
                        @if ($rewardRedemption->status === 'completed')
                            <span class="rounded-full bg-green-100 px-3 py-1.5 text-xs font-medium text-green-700">
                                Completed
                            </span>
                        @elseif ($rewardRedemption->status === 'rejected')
                            <span class="rounded-full bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700">
                                Rejected
                            </span>
                        @elseif ($rewardRedemption->status === 'approved')
                            <span class="rounded-full bg-blue-100 px-3 py-1.5 text-xs font-medium text-blue-700">
                                Approved
                            </span>
                        @else
                            <span class="rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700">
                                Requested
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm text-slate-500">Reward</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $rewardRedemption->reward->reward_name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poin Digunakan</p>
                        <p class="mt-1 text-2xl font-bold text-blue-700">{{ number_format($rewardRedemption->points_used) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tanggal Pengajuan</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $rewardRedemption->redeemed_at ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Diproses Oleh</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $rewardRedemption->processor->name ?? '-' }}</p>
                    </div>

                    @if ($rewardRedemption->processed_at)
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Diproses</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $rewardRedemption->processed_at }}</p>
                        </div>
                    @endif

                    @if ($rewardRedemption->completed_at)
                        <div>
                            <p class="text-sm text-slate-500">Tanggal Selesai</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $rewardRedemption->completed_at }}</p>
                        </div>
                    @endif

                    @if ($rewardRedemption->rejection_reason)
                        <div class="md:col-span-2 rounded-2xl bg-red-50 p-4">
                            <p class="text-sm font-medium text-red-700">Alasan Penolakan</p>
                            <p class="mt-1 text-sm leading-6 text-red-700">
                                {{ $rewardRedemption->rejection_reason }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
