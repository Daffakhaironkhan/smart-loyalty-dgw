<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTransaction;
use App\Models\PointHistory;
use App\Models\RewardRedemption;
use App\Models\StorePurchaseTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $customerTransactionsQuery = CustomerTransaction::query();
        $storePurchasesQuery = StorePurchaseTransaction::query();
        $rewardRedemptionsQuery = RewardRedemption::query();
        $pointHistoriesQuery = PointHistory::query();

        if ($startDate && $endDate) {
            $customerTransactionsQuery->whereBetween('transaction_date', [$startDate, $endDate]);
            $storePurchasesQuery->whereBetween('transaction_date', [$startDate, $endDate]);
            $rewardRedemptionsQuery->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59',
            ]);
            $pointHistoriesQuery->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59',
            ]);
        }

        $summary = [
            'customer_transaction_count' => (clone $customerTransactionsQuery)->count(),
            'customer_transaction_amount' => (clone $customerTransactionsQuery)->sum('total_amount'),
            'customer_transaction_points' => (clone $customerTransactionsQuery)->sum('total_customer_points'),

            'store_purchase_count' => (clone $storePurchasesQuery)->count(),
            'store_purchase_amount' => (clone $storePurchasesQuery)->sum('total_amount'),
            'store_purchase_points' => (clone $storePurchasesQuery)->sum('total_store_points'),

            'reward_redemption_count' => (clone $rewardRedemptionsQuery)->count(),
            'reward_redemption_points' => (clone $rewardRedemptionsQuery)->sum('points_used'),

            'point_in' => (clone $pointHistoriesQuery)
                ->where('point_type', 'in')
                ->sum('points'),

            'point_out' => (clone $pointHistoriesQuery)
                ->where('point_type', 'out')
                ->sum('points'),
        ];

        $recentCustomerTransactions = (clone $customerTransactionsQuery)
            ->with(['store', 'customer'])
            ->latest()
            ->take(10)
            ->get();

        $recentStorePurchases = (clone $storePurchasesQuery)
            ->with('store')
            ->latest()
            ->take(10)
            ->get();

        $recentRewardRedemptions = (clone $rewardRedemptionsQuery)
            ->with(['user', 'reward'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'summary',
            'startDate',
            'endDate',
            'recentCustomerTransactions',
            'recentStorePurchases',
            'recentRewardRedemptions'
        ));
    }

    public function exportCustomerTransactionsCsv(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $customerTransactionsQuery = CustomerTransaction::with(['store', 'customer']);

        if ($startDate && $endDate) {
            $customerTransactionsQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $transactions = $customerTransactionsQuery
            ->latest()
            ->get();

        $fileName = 'laporan-transaksi-konsumen-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Transaksi',
                'Tanggal',
                'Toko/Kios',
                'Konsumen',
                'Total Amount',
                'Total Poin Konsumen',
                'Status',
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_code,
                    $transaction->transaction_date,
                    $transaction->store->store_name ?? '-',
                    $transaction->customer->name ?? '-',
                    $transaction->total_amount,
                    $transaction->total_customer_points,
                    $transaction->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportStorePurchasesCsv(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $storePurchasesQuery = StorePurchaseTransaction::with('store');

        if ($startDate && $endDate) {
            $storePurchasesQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $purchases = $storePurchasesQuery
            ->latest()
            ->get();

        $fileName = 'laporan-pembelian-toko-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($purchases) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Pembelian',
                'Tanggal',
                'Toko/Kios',
                'Nomor Invoice',
                'Total Amount',
                'Total Poin Toko',
                'Status',
            ]);

            foreach ($purchases as $purchase) {
                fputcsv($file, [
                    $purchase->transaction_code,
                    $purchase->transaction_date,
                    $purchase->store->store_name ?? '-',
                    $purchase->invoice_number ?? '-',
                    $purchase->total_amount,
                    $purchase->total_store_points,
                    $purchase->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportRewardRedemptionsCsv(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $rewardRedemptionsQuery = RewardRedemption::with(['user', 'reward']);

        if ($startDate && $endDate) {
            $rewardRedemptionsQuery->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59',
            ]);
        }

        $redemptions = $rewardRedemptionsQuery
            ->latest()
            ->get();

        $fileName = 'laporan-penukaran-reward-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($redemptions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Penukaran',
                'Tanggal Pengajuan',
                'User',
                'Reward',
                'Poin Digunakan',
                'Status',
                'Diproses Pada',
                'Selesai Pada',
                'Alasan Penolakan',
            ]);

            foreach ($redemptions as $redemption) {
                fputcsv($file, [
                    $redemption->redemption_code,
                    $redemption->redeemed_at ?? $redemption->created_at,
                    $redemption->user->name ?? '-',
                    $redemption->reward->reward_name ?? '-',
                    $redemption->points_used,
                    $redemption->status,
                    $redemption->processed_at ?? '-',
                    $redemption->completed_at ?? '-',
                    $redemption->rejection_reason ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
