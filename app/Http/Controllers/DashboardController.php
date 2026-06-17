<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Product;
use App\Models\Reward;
use App\Models\RewardRedemption;
use App\Models\Store;
use App\Models\StorePurchaseTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('toko_kios')) {
            return redirect()->route('toko.dashboard');
        }

        if ($user->hasRole('konsumen')) {
            return redirect()->route('konsumen.dashboard');
        }

        abort(403, 'Role pengguna tidak dikenali.');
    }

    public function admin()
    {
        $totalStores = Store::count();
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();

        $pendingCustomerTransactions = CustomerTransaction::where('status', 'pending')->count();
        $pendingStorePurchases = StorePurchaseTransaction::where('status', 'pending')->count();
        $pendingRewardRedemptions = RewardRedemption::where('status', 'requested')->count();

        $recentCustomerTransactions = CustomerTransaction::with(['store', 'customer'])
            ->latest()
            ->take(5)
            ->get();

        $recentStorePurchases = StorePurchaseTransaction::with('store')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.admin', compact(
            'totalStores',
            'totalCustomers',
            'totalProducts',
            'pendingCustomerTransactions',
            'pendingStorePurchases',
            'pendingRewardRedemptions',
            'recentCustomerTransactions',
            'recentStorePurchases'
        ));
    }

    public function toko()
    {
        $store = auth()->user()->store;

        if (!$store) {
            abort(403, 'Akun ini tidak terhubung dengan data Toko/Kios.');
        }

        $totalPoints = $store->total_points;

        $pendingCustomerTransactions = CustomerTransaction::where('store_id', $store->id)
            ->where('status', 'pending')
            ->count();

        $pendingStorePurchases = StorePurchaseTransaction::where('store_id', $store->id)
            ->where('status', 'pending')
            ->count();

        $totalRewardRedemptions = RewardRedemption::where('user_id', auth()->id())
            ->count();

        $recentCustomerTransactions = CustomerTransaction::with('customer')
            ->where('store_id', $store->id)
            ->latest()
            ->take(5)
            ->get();

        $recentStorePurchases = StorePurchaseTransaction::where('store_id', $store->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.toko', compact(
            'store',
            'totalPoints',
            'pendingCustomerTransactions',
            'pendingStorePurchases',
            'totalRewardRedemptions',
            'recentCustomerTransactions',
            'recentStorePurchases'
        ));
    }

    public function konsumen()
    {
        $customer = auth()->user()->customer;

        if (!$customer) {
            abort(403, 'Akun ini tidak terhubung dengan data konsumen.');
        }

        $totalPoints = $customer->total_points;

        $totalTransactions = CustomerTransaction::where('customer_id', $customer->id)
            ->count();

        $totalRewardRedemptions = RewardRedemption::where('user_id', auth()->id())
            ->count();

        $availableRewards = Reward::where('status', 'active')
            ->where('stock', '>', 0)
            ->whereIn('redeemable_by', ['customer', 'both'])
            ->count();

        $recentTransactions = CustomerTransaction::with('store')
            ->where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        $recentRewardRedemptions = RewardRedemption::with('reward')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.konsumen', compact(
            'customer',
            'totalPoints',
            'totalTransactions',
            'totalRewardRedemptions',
            'availableRewards',
            'recentTransactions',
            'recentRewardRedemptions'
        ));
    }
}
