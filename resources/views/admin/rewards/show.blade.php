<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Detail Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Detail Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Lihat detail reward, jumlah poin yang dibutuhkan, stok tersedia, status, dan target penukaran.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.rewards.index') }}" variant="secondary">
                    Kembali
                </x-ui.button>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-slate-500">Kode Reward</p>
                        <p class="font-semibold">{{ $reward->reward_code }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Nama Reward</p>
                        <p class="font-semibold">{{ $reward->reward_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Poin Dibutuhkan</p>
                        <p class="font-semibold">{{ number_format($reward->required_points) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Stok</p>
                        <p class="font-semibold">{{ number_format($reward->stock) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Bisa Ditukar Oleh</p>
                        <p class="font-semibold">
                            @if ($reward->redeemable_by === 'customer')
                                Konsumen
                            @elseif ($reward->redeemable_by === 'store')
                                Toko/Kios
                            @else
                                Konsumen & Toko/Kios
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Status</p>
                        @if ($reward->status === 'active')
                            <span class="mt-1 inline-block rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                Active
                            </span>
                        @elseif ($reward->status === 'out_of_stock')
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-slate-100 text-slate-700 rounded">
                                Out of Stock
                            </span>
                        @else
                            <span class="mt-1 inline-block rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Dibuat Oleh</p>
                        <p class="font-semibold">{{ $reward->creator->name ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-500">Deskripsi</p>
                        <p class="font-semibold">{{ $reward->description ?? '-' }}</p>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.rewards.edit', $reward) }}"
                       class="rounded-xl bg-yellow-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600">
                        Edit Reward
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
