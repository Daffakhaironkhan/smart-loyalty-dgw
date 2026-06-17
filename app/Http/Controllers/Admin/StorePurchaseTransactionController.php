<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use App\Models\StorePurchaseTransaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorePurchaseTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = StorePurchaseTransaction::with('store');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                    ->orWhere('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('store', function ($storeQuery) use ($search) {
                        $storeQuery->where('store_name', 'like', "%{$search}%")
                            ->orWhere('store_code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $storePurchases = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.store-purchases.index', compact('storePurchases'));
    }

    public function show(StorePurchaseTransaction $storePurchase)
    {
        $storePurchase->load([
            'store.user',
            'items.product',
            'items.pointRule',
            'approver',
        ]);

        return view('admin.store-purchases.show', compact('storePurchase'));
    }

    public function approve(StorePurchaseTransaction $storePurchase)
    {
        if ($storePurchase->status !== 'pending') {
            return redirect()
                ->route('admin.store-purchases.show', $storePurchase)
                ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($storePurchase) {
            $store = $storePurchase->store;

            $newBalance = $store->total_points + $storePurchase->total_store_points;

            $store->update([
                'total_points' => $newBalance,
            ]);

            $storePurchase->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ]);

            activity_log(
                'approve',
                'store_purchase',
                $storePurchase,
                'Menyetujui pembelian toko/kios dengan kode ' . $storePurchase->transaction_code
            );

            PointHistory::create([
                'user_id' => $store->user_id,
                'source_type' => 'store_purchase_transaction',
                'source_id' => $storePurchase->id,
                'point_type' => 'in',
                'points' => $storePurchase->total_store_points,
                'balance_after' => $newBalance,
                'description' => 'Poin masuk dari pembelian Toko/Kios ke DGW ' . $storePurchase->transaction_code,
                'created_by' => auth()->id(),
            ]);

            Notification::create([
                'user_id' => $store->user_id,
                'title' => 'Pembelian ke DGW Disetujui',
                'message' => 'Pembelian ' . $storePurchase->transaction_code . ' telah disetujui. Poin sebesar ' . number_format($storePurchase->total_store_points) . ' berhasil ditambahkan.',
                'type' => 'store_purchase_approved',
                'link' => route('toko.point-histories.index'),
            ]);
        });

        return redirect()
            ->route('admin.store-purchases.show', $storePurchase)
            ->with('success', 'Pembelian berhasil disetujui dan poin Toko/Kios berhasil ditambahkan.');
    }

    public function reject(Request $request, StorePurchaseTransaction $storePurchase)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        if ($storePurchase->status !== 'pending') {
            return redirect()
                ->route('admin.store-purchases.show', $storePurchase)
                ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $storePurchase->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        activity_log(
            'reject',
            'store_purchase',
            $storePurchase,
            'Menolak pembelian toko/kios dengan kode ' . $storePurchase->transaction_code
        );

        $store = $storePurchase->store;

        if ($store && $store->user_id) {
            Notification::create([
                'user_id' => $store->user_id,
                'title' => 'Pembelian ke DGW Ditolak',
                'message' => 'Pembelian ' . $storePurchase->transaction_code . ' ditolak. Alasan: ' . $request->rejection_reason,
                'type' => 'store_purchase_rejected',
                'link' => route('toko.store-purchases.show', $storePurchase),
            ]);
        }

        return redirect()
            ->route('admin.store-purchases.show', $storePurchase)
            ->with('success', 'Pembelian berhasil ditolak.');
    }
}
