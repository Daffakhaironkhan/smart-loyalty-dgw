<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Activity Log
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    Activity Log
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau riwayat aktivitas pengguna, aksi, modul, dan deskripsi perubahan dalam sistem.
                </p>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="GET" action="{{ route('admin.activity-logs.index') }}">
                    <div class="grid grid-cols-1 items-end gap-4 md:grid-cols-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700">Cari</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="User, aksi, modul, deskripsi..."
                                   class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Module</label>
                            <select name="module"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Module</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module }}" {{ request('module') === $module ? 'selected' : '' }}>
                                        {{ $module }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Action</label>
                            <select name="action"
                                    class="mt-1 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Action</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                        {{ $action }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <x-ui.button type="submit">Filter</x-ui.button>
                            <x-ui.button href="{{ route('admin.activity-logs.index') }}" variant="secondary">Reset</x-ui.button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Action</th>
                            <th class="px-4 py-3">Module</th>
                            <th class="px-4 py-3">Deskripsi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($logs as $log)
                            <tr class="border-t border-slate-100">
                                <td class="whitespace-nowrap px-4 py-3 text-slate-700">
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ $log->user->email ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                            {{ $log->action }}
                                        </span>
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $log->module ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $log->description ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                    Belum ada activity log.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
