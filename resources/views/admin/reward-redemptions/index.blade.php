<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Validasi Penukaran Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Validasi Penukaran Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Tinjau pengajuan reward sebelum disetujui, diproses, diselesaikan, atau ditolak oleh Admin.
                    </p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-sm font-medium text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-xl bg-red-100 p-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.reward-redemptions.index') }}">
                    <div class="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Cari</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode penukaran, nama user, nama reward..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Status</label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="requested" {{ request('status') === 'requested' ? 'selected' : '' }}>Requested</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Processed</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">Filter</x-ui.button>
                            <x-ui.button href="{{ route('admin.reward-redemptions.index') }}" variant="secondary">Reset</x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Reward</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Tanggal Pengajuan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($rewardRedemptions as $redemption)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">{{ $redemption->redemption_code }}</td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $redemption->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $redemption->reward->reward_name ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format($redemption->points_used) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $redemption->redeemed_at ?? $redemption->created_at }}</td>
                                <td class="px-4 py-3">
                                    @if ($redemption->status === 'completed')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">Completed</span>
                                    @elseif ($redemption->status === 'rejected')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Rejected</span>
                                    @elseif ($redemption->status === 'approved')
                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">Approved</span>
                                    @elseif ($redemption->status === 'processed')
                                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700">Processed</span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">Requested</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.reward-redemptions.show', $redemption) }}"
                                       class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                                    Belum ada pengajuan penukaran reward.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $rewardRedemptions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
