<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Konsumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Konsumen
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola data konsumen, status member, toko pendaftar, dan informasi poin.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.customers.create') }}">
                    + Tambah Konsumen
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-xl bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.customers.index') }}">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:items-end">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Cari
                            </label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode member, nama, phone, email, toko..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Gender
                            </label>
                            <select name="gender"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                                <option value="">Semua Gender</option>
                                <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">
                                Status
                            </label>
                            <select name="status"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-b border-slate-100lue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">
                                Filter
                            </x-ui.button>

                            <x-ui.button href="{{ route('admin.customers.index') }}" variant="secondary">
                                Reset
                            </x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[1000px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Kode Member</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">No. Telepon</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Toko Pendaftar</th>
                            <th class="px-4 py-3">Poin</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($customers as $customer)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3">
                                    {{ $customer->member_code }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $customer->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $customer->phone ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $customer->email ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $customer->registeredByStore->store_name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ number_format($customer->total_points) }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($customer->status === 'active')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                    Active
                                </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                    Inactive
                                </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.customers.show', $customer) }}"
                                           class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-200">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.customers.edit', $customer) }}"
                                           class="rounded-xl bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.customers.toggle-status', $customer) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="rounded-xl px-3 py-1.5 text-xs font-medium {{ $customer->status === 'active' ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                                {{ $customer->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.customers.destroy', $customer) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data konsumen ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-xl bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data konsumen.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
