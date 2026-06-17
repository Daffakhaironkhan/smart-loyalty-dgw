<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-slate-900">
            Program Poin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Manajemen Program Poin
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Kelola periode program poin, status program, dan aturan poin yang terhubung.
                    </p>
                </div>

                <x-ui.button href="{{ route('admin.point-programs.create') }}">
                    + Tambah Program
                </x-ui.button>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3">Nama Program</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Jumlah Aturan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($programs as $program)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $program->program_name }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $program->start_date }} s/d {{ $program->end_date }}
                                </td>

                                <td class="px-4 py-3 text-slate-700">
                                    {{ $program->rules_count }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($program->status === 'active')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                            Active
                                        </span>
                                    @elseif ($program->status === 'expired')
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                            Expired
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.point-programs.show', $program) }}"
                                           class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-200">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.point-programs.edit', $program) }}"
                                           class="rounded-lg bg-yellow-100 px-3 py-1.5 text-xs font-medium text-yellow-700 hover:bg-yellow-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.point-programs.destroy', $program) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus program poin ini?')">
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
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                                    Belum ada data program poin.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $programs->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
