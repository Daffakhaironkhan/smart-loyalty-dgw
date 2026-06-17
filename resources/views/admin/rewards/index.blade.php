<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Reward
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Reward
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola katalog reward, kebutuhan poin, stok, status, dan target penukaran reward.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.rewards.create') }}">
                    + Tambah Reward
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.rewards.index') }}">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:items-end">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Cari
                            </label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode reward, nama reward..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Redeemable By
                            </label>
                            <select name="redeemable_by"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua</option>
                                <option value="customer" {{ request('redeemable_by') === 'customer' ? 'selected' : '' }}>
                                    Customer
                                </option>
                                <option value="store" {{ request('redeemable_by') === 'store' ? 'selected' : '' }}>
                                    Store
                                </option>
                                <option value="both" {{ request('redeemable_by') === 'both' ? 'selected' : '' }}>
                                    Both
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">
                                Filter
                            </x-ui.button>

                            <x-ui.button href="{{ route('admin.stores.index') }}" variant="secondary">
                                Reset
                            </x-ui.button>
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
                            <th class="px-4 py-3">Nama Reward</th>
                            <th class="px-4 py-3">Poin Dibutuhkan</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Bisa Ditukar Oleh</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($rewards as $reward)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $reward->reward_code }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $reward->reward_name }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($reward->required_points) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ number_format($reward->stock) }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    @if ($reward->redeemable_by === 'customer')
                                        Konsumen
                                    @elseif ($reward->redeemable_by === 'store')
                                        Toko/Kios
                                    @else
                                        Konsumen & Toko/Kios
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    @if ($reward->status === 'active')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                Active
                                            </span>
                                    @elseif ($reward->status === 'out_of_stock')
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                                Out of Stock
                                            </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                                Inactive
                                            </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.rewards.show', $reward) }}"
                                           class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-200">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.rewards.edit', $reward) }}"
                                           class="rounded-lg bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.rewards.destroy', $reward) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus reward ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data reward.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $rewards->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
