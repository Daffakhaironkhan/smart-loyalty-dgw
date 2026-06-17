<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::where('status', 'active')
            ->where('stock', '>', 0)
            ->whereIn('redeemable_by', ['store', 'both'])
            ->latest()
            ->paginate(10);

        return view('toko.rewards.index', compact('rewards'));
    }

    public function show(Reward $reward)
    {
        if (
            $reward->status !== 'active'
            || $reward->stock <= 0
            || !in_array($reward->redeemable_by, ['store', 'both'])
        ) {
            abort(404);
        }

        return view('toko.rewards.show', compact('reward'));
    }
}
