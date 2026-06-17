<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTransaction;
use App\Models\PointHistory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerTransaction::with(['store', 'customer']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                    ->orWhereHas('store', function ($storeQuery) use ($search) {
                        $storeQuery->where('store_name', 'like', "%{$search}%")
                            ->orWhere('store_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('member_code', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customerTransactions = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customer-transactions.index', compact('customerTransactions'));
    }

    public function show(CustomerTransaction $customerTransaction)
    {
        $customerTransaction->load([
            'store',
            'customer.user',
            'items.product',
            'items.pointRule',
            'approver',
        ]);

        return view('admin.customer-transactions.show', compact('customerTransaction'));
    }

    public function approve(CustomerTransaction $customerTransaction)
    {
        if ($customerTransaction->status !== 'pending') {
            return redirect()
                ->route('admin.customer-transactions.show', $customerTransaction)
                ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($customerTransaction) {
            $customer = $customerTransaction->customer;

            $newBalance = $customer->total_points + $customerTransaction->total_customer_points;

            $customer->update([
                'total_points' => $newBalance,
            ]);

            $customerTransaction->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ]);

            if ($customer->user_id) {
                PointHistory::create([
                    'user_id' => $customer->user_id,
                    'source_type' => 'customer_transaction',
                    'source_id' => $customerTransaction->id,
                    'point_type' => 'in',
                    'points' => $customerTransaction->total_customer_points,
                    'balance_after' => $newBalance,
                    'description' => 'Poin masuk dari transaksi konsumen ' . $customerTransaction->transaction_code,
                    'created_by' => auth()->id(),
                ]);
            }

            if ($customer->user_id) {
                Notification::create([
                    'user_id' => $customer->user_id,
                    'title' => 'Transaksi Konsumen Disetujui',
                    'message' => 'Transaksi ' . $customerTransaction->transaction_code . ' telah disetujui. Poin sebesar ' . number_format($customerTransaction->total_customer_points) . ' berhasil ditambahkan.',
                    'type' => 'customer_transaction_approved',
                    'link' => route('konsumen.point-histories.index'),
                ]);
            }
        });

        return redirect()
            ->route('admin.customer-transactions.show', $customerTransaction)
            ->with('success', 'Transaksi berhasil disetujui dan poin konsumen berhasil ditambahkan.');
    }

    public function reject(Request $request, CustomerTransaction $customerTransaction)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        if ($customerTransaction->status !== 'pending') {
            return redirect()
                ->route('admin.customer-transactions.show', $customerTransaction)
                ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $customerTransaction->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        $customer = $customerTransaction->customer;

        if ($customer && $customer->user_id) {
            Notification::create([
                'user_id' => $customer->user_id,
                'title' => 'Transaksi Konsumen Ditolak',
                'message' => 'Transaksi ' . $customerTransaction->transaction_code . ' ditolak. Alasan: ' . $request->rejection_reason,
                'type' => 'customer_transaction_rejected',
                'link' => route('konsumen.point-histories.index'),
            ]);
        }

        return redirect()
            ->route('admin.customer-transactions.show', $customerTransaction)
            ->with('success', 'Transaksi berhasil ditolak.');
    }
}
