<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $query = Reward::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('reward_code', 'like', "%{$search}%")
                    ->orWhere('reward_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('redeemable_by')) {
            $query->where('redeemable_by', $request->redeemable_by);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rewards = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('admin.rewards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reward_code' => ['required', 'string', 'max:50', 'unique:rewards,reward_code'],
            'reward_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'required_points' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'redeemable_by' => ['required', 'in:customer,store,both'],
            'status' => ['required', 'in:active,inactive,out_of_stock'],
        ]);

        Reward::create([
            'reward_code' => $request->reward_code,
            'reward_name' => $request->reward_name,
            'description' => $request->description,
            'required_points' => $request->required_points,
            'stock' => $request->stock,
            'redeemable_by' => $request->redeemable_by,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil ditambahkan.');
    }

    public function show(Reward $reward)
    {
        $reward->load('creator');

        return view('admin.rewards.show', compact('reward'));
    }

    public function edit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'reward_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rewards', 'reward_code')->ignore($reward->id),
            ],
            'reward_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'required_points' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'redeemable_by' => ['required', 'in:customer,store,both'],
            'status' => ['required', 'in:active,inactive,out_of_stock'],
        ]);

        $reward->update([
            'reward_code' => $request->reward_code,
            'reward_name' => $request->reward_name,
            'description' => $request->description,
            'required_points' => $request->required_points,
            'stock' => $request->stock,
            'redeemable_by' => $request->redeemable_by,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return redirect()
            ->route('admin.rewards.index')
            ->with('success', 'Reward berhasil dihapus.');
    }
}
