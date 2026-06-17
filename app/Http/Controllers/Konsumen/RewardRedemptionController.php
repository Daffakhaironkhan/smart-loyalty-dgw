<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\RewardRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardRedemptionController extends Controller
{
    public function index()
    {
        $redemptions = RewardRedemption::with('reward')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('konsumen.reward-redemptions.index', compact('redemptions'));
    }

    public function store(Request $request, Reward $reward)
    {
        if (
            $reward->status !== 'active'
            || $reward->stock <= 0
            || !in_array($reward->redeemable_by, ['customer', 'both'])
        ) {
            abort(404);
        }

        $customer = auth()->user()->customer;

        if (!$customer) {
            abort(403, 'Akun ini tidak terhubung dengan data konsumen.');
        }

        if ($customer->total_points < $reward->required_points) {
            return back()->with('error', 'Poin konsumen tidak mencukupi untuk menukar reward ini.');
        }

        DB::transaction(function () use ($reward) {
            RewardRedemption::create([
                'redemption_code' => $this->generateRedemptionCode(),
                'user_id' => auth()->id(),
                'reward_id' => $reward->id,
                'points_used' => $reward->required_points,
                'status' => 'requested',
                'redeemed_at' => now(),
            ]);
        });

        return redirect()
            ->route('konsumen.reward-redemptions.index')
            ->with('success', 'Pengajuan penukaran reward berhasil dibuat dan menunggu validasi admin.');
    }

    public function show(RewardRedemption $rewardRedemption)
    {
        if ($rewardRedemption->user_id !== auth()->id()) {
            abort(403);
        }

        $rewardRedemption->load(['reward', 'processor']);

        return view('konsumen.reward-redemptions.show', compact('rewardRedemption'));
    }

    private function generateRedemptionCode(): string
    {
        $last = RewardRedemption::latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;

        return 'RR-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
