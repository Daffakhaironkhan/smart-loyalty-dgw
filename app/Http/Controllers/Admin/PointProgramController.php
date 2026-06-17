<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointProgram;
use Illuminate\Http\Request;

class PointProgramController extends Controller
{
    public function index()
    {
        $programs = PointProgram::withCount('rules')
            ->latest()
            ->paginate(10);

        return view('admin.point-programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.point-programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive,expired'],
        ]);

        PointProgram::create([
            'program_name' => $request->program_name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.point-programs.index')
            ->with('success', 'Program poin berhasil ditambahkan.');
    }

    public function show(PointProgram $pointProgram)
    {
        $pointProgram->load(['rules.product', 'creator']);

        return view('admin.point-programs.show', compact('pointProgram'));
    }

    public function edit(PointProgram $pointProgram)
    {
        return view('admin.point-programs.edit', compact('pointProgram'));
    }

    public function update(Request $request, PointProgram $pointProgram)
    {
        $request->validate([
            'program_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive,expired'],
        ]);

        $pointProgram->update([
            'program_name' => $request->program_name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.point-programs.index')
            ->with('success', 'Program poin berhasil diperbarui.');
    }

    public function destroy(PointProgram $pointProgram)
    {
        $pointProgram->delete();

        return redirect()
            ->route('admin.point-programs.index')
            ->with('success', 'Program poin berhasil dihapus.');
    }
}
