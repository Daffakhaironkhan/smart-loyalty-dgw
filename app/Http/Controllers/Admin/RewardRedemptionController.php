<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use App\Models\RewardRedemption;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RewardRedemptionController extends Controller
{
    public function index(Request $request)
    {
        $query = RewardRedemption::with(['user', 'reward']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('redemption_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('reward', function ($rewardQuery) use ($search) {
                        $rewardQuery->where('reward_name', 'like', "%{$search}%")
                            ->orWhere('reward_code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rewardRedemptions = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reward-redemptions.index', compact('rewardRedemptions'));
    }

    public function show(RewardRedemption $rewardRedemption)
    {
        $rewardRedemption->load([
            'user.store',
            'user.customer',
            'reward',
            'processor',
        ]);

        return view('admin.reward-redemptions.show', compact('rewardRedemption'));
    }

    public function approve(RewardRedemption $rewardRedemption)
    {
        if ($rewardRedemption->status !== 'requested') {
            return redirect()
                ->route('admin.reward-redemptions.show', $rewardRedemption)
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $rewardRedemption->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'rejection_reason' => null,
        ]);

        activity_log(
            'approve',
            'reward_redemption',
            $rewardRedemption,
            'Menyetujui penukaran reward dengan kode ' . $rewardRedemption->redemption_code
        );

        Notification::create([
            'user_id' => $rewardRedemption->user_id,
            'title' => 'Penukaran Reward Disetujui',
            'message' => 'Pengajuan penukaran reward ' . $rewardRedemption->redemption_code . ' telah disetujui.',
            'type' => 'reward_redemption_approved',
            'link' => route($rewardRedemption->user->hasRole('toko_kios') ? 'toko.reward-redemptions.show' : 'konsumen.reward-redemptions.show', $rewardRedemption),
        ]);

        return redirect()
            ->route('admin.reward-redemptions.show', $rewardRedemption)
            ->with('success', 'Pengajuan penukaran reward berhasil disetujui.');
    }

    public function complete(RewardRedemption $rewardRedemption)
    {
        if ($rewardRedemption->status !== 'approved') {
            return redirect()
                ->route('admin.reward-redemptions.show', $rewardRedemption)
                ->with('error', 'Penukaran hanya bisa diselesaikan jika status sudah approved.');
        }

        DB::transaction(function () use ($rewardRedemption) {
            $reward = $rewardRedemption->reward;
            $user = $rewardRedemption->user;

            if ($reward->stock <= 0) {
                throw new \Exception('Stok reward sudah habis.');
            }

            if ($user->hasRole('toko_kios')) {
                $store = $user->store;

                if (!$store) {
                    throw new \Exception('Data Toko/Kios tidak ditemukan.');
                }

                if ($store->total_points < $rewardRedemption->points_used) {
                    throw new \Exception('Poin Toko/Kios tidak mencukupi.');
                }

                $newBalance = $store->total_points - $rewardRedemption->points_used;

                $store->update([
                    'total_points' => $newBalance,
                ]);

                PointHistory::create([
                    'user_id' => $user->id,
                    'source_type' => 'reward_redemption',
                    'source_id' => $rewardRedemption->id,
                    'point_type' => 'out',
                    'points' => $rewardRedemption->points_used,
                    'balance_after' => $newBalance,
                    'description' => 'Penukaran reward ' . $reward->reward_name . ' (' . $rewardRedemption->redemption_code . ')',
                    'created_by' => auth()->id(),
                ]);
            }

            if ($user->hasRole('konsumen')) {
                $customer = $user->customer;

                if (!$customer) {
                    throw new \Exception('Data konsumen tidak ditemukan.');
                }

                if ($customer->total_points < $rewardRedemption->points_used) {
                    throw new \Exception('Poin konsumen tidak mencukupi.');
                }

                $newBalance = $customer->total_points - $rewardRedemption->points_used;

                $customer->update([
                    'total_points' => $newBalance,
                ]);

                PointHistory::create([
                    'user_id' => $user->id,
                    'source_type' => 'reward_redemption',
                    'source_id' => $rewardRedemption->id,
                    'point_type' => 'out',
                    'points' => $rewardRedemption->points_used,
                    'balance_after' => $newBalance,
                    'description' => 'Penukaran reward ' . $reward->reward_name . ' (' . $rewardRedemption->redemption_code . ')',
                    'created_by' => auth()->id(),
                ]);
            }

            $reward->update([
                'stock' => $reward->stock - 1,
                'status' => ($reward->stock - 1) <= 0 ? 'out_of_stock' : $reward->status,
            ]);

            $rewardRedemption->update([
                'status' => 'completed',
                'processed_by' => auth()->id(),
                'processed_at' => $rewardRedemption->processed_at ?? now(),
                'completed_at' => now(),
            ]);

            activity_log(
                'complete',
                'reward_redemption',
                $rewardRedemption,
                'Menyelesaikan penukaran reward dengan kode ' . $rewardRedemption->redemption_code
            );

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Penukaran Reward Selesai',
                'message' => 'Penukaran reward ' . $reward->reward_name . ' telah selesai. Poin sebesar ' . number_format($rewardRedemption->points_used) . ' telah dikurangi.',
                'type' => 'reward_redemption_completed',
                'link' => route($user->hasRole('toko_kios') ? 'toko.reward-redemptions.show' : 'konsumen.reward-redemptions.show', $rewardRedemption),
            ]);
        });

        return redirect()
            ->route('admin.reward-redemptions.show', $rewardRedemption)
            ->with('success', 'Penukaran reward berhasil diselesaikan. Poin dan stok berhasil diperbarui.');
    }

    public function reject(Request $request, RewardRedemption $rewardRedemption)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        if (!in_array($rewardRedemption->status, ['requested', 'approved'])) {
            return redirect()
                ->route('admin.reward-redemptions.show', $rewardRedemption)
                ->with('error', 'Pengajuan ini tidak bisa ditolak karena sudah selesai/diproses.');
        }

        $rewardRedemption->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        activity_log(
            'reject',
            'reward_redemption',
            $rewardRedemption,
            'Menolak penukaran reward dengan kode ' . $rewardRedemption->redemption_code
        );

        $rewardRedemption->load('user');

        Notification::create([
            'user_id' => $rewardRedemption->user_id,
            'title' => 'Penukaran Reward Ditolak',
            'message' => 'Pengajuan penukaran reward ' . $rewardRedemption->redemption_code . ' ditolak. Alasan: ' . $request->rejection_reason,
            'type' => 'reward_redemption_rejected',
            'link' => route($rewardRedemption->user->hasRole('toko_kios') ? 'toko.reward-redemptions.show' : 'konsumen.reward-redemptions.show', $rewardRedemption),
        ]);

        return redirect()
            ->route('admin.reward-redemptions.show', $rewardRedemption)
            ->with('success', 'Pengajuan penukaran reward berhasil ditolak.');
    }
}
