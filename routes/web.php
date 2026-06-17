<?php

use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PointProgramController;
use App\Http\Controllers\Admin\PointRuleController;
use App\Http\Controllers\Toko\CustomerTransactionController as TokoCustomerTransactionController;
use App\Http\Controllers\Admin\CustomerTransactionController as AdminCustomerTransactionController;
use App\Http\Controllers\Toko\StorePurchaseTransactionController as TokoStorePurchaseTransactionController;
use App\Http\Controllers\Admin\StorePurchaseTransactionController as AdminStorePurchaseTransactionController;
use App\Http\Controllers\Admin\PointHistoryController as AdminPointHistoryController;
use App\Http\Controllers\Toko\PointHistoryController as TokoPointHistoryController;
use App\Http\Controllers\Konsumen\PointHistoryController as KonsumenPointHistoryController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Toko\RewardController as TokoRewardController;
use App\Http\Controllers\Toko\RewardRedemptionController as TokoRewardRedemptionController;
use App\Http\Controllers\Konsumen\RewardController as KonsumenRewardController;
use App\Http\Controllers\Konsumen\RewardRedemptionController as KonsumenRewardRedemptionController;
use App\Http\Controllers\Admin\RewardRedemptionController as AdminRewardRedemptionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])
        ->name('notifications.show');

    Route::patch('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-as-read');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        Route::resource('users', UserController::class);
        Route::patch('/stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])
            ->name('stores.toggle-status');

        Route::resource('stores', StoreController::class);

        Route::patch('/customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])
            ->name('customers.toggle-status');

        Route::resource('customers', CustomerController::class);

        Route::resource('product-categories', ProductCategoryController::class)
            ->except(['show']);

        Route::resource('products', ProductController::class);

        Route::resource('point-programs', PointProgramController::class);
        Route::resource('point-rules', PointRuleController::class)->except(['show']);

        Route::get('/customer-transactions', [AdminCustomerTransactionController::class, 'index'])
            ->name('customer-transactions.index');

        Route::get('/customer-transactions/{customerTransaction}', [AdminCustomerTransactionController::class, 'show'])
            ->name('customer-transactions.show');

        Route::patch('/customer-transactions/{customerTransaction}/approve', [AdminCustomerTransactionController::class, 'approve'])
            ->name('customer-transactions.approve');

        Route::patch('/customer-transactions/{customerTransaction}/reject', [AdminCustomerTransactionController::class, 'reject'])
            ->name('customer-transactions.reject');

        Route::get('/store-purchases', [AdminStorePurchaseTransactionController::class, 'index'])
            ->name('store-purchases.index');

        Route::get('/store-purchases/{storePurchase}', [AdminStorePurchaseTransactionController::class, 'show'])
            ->name('store-purchases.show');

        Route::patch('/store-purchases/{storePurchase}/approve', [AdminStorePurchaseTransactionController::class, 'approve'])
            ->name('store-purchases.approve');

        Route::patch('/store-purchases/{storePurchase}/reject', [AdminStorePurchaseTransactionController::class, 'reject'])
            ->name('store-purchases.reject');

        Route::get('/point-histories', [AdminPointHistoryController::class, 'index'])
            ->name('point-histories.index');

        Route::resource('rewards', RewardController::class);

        Route::get('/reward-redemptions', [AdminRewardRedemptionController::class, 'index'])
            ->name('reward-redemptions.index');

        Route::get('/reward-redemptions/{rewardRedemption}', [AdminRewardRedemptionController::class, 'show'])
            ->name('reward-redemptions.show');

        Route::patch('/reward-redemptions/{rewardRedemption}/approve', [AdminRewardRedemptionController::class, 'approve'])
            ->name('reward-redemptions.approve');

        Route::patch('/reward-redemptions/{rewardRedemption}/complete', [AdminRewardRedemptionController::class, 'complete'])
            ->name('reward-redemptions.complete');

        Route::patch('/reward-redemptions/{rewardRedemption}/reject', [AdminRewardRedemptionController::class, 'reject'])
            ->name('reward-redemptions.reject');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/export/customer-transactions', [ReportController::class, 'exportCustomerTransactionsCsv'])
            ->name('reports.export.customer-transactions');

        Route::get('/reports/export/store-purchases', [ReportController::class, 'exportStorePurchasesCsv'])
            ->name('reports.export.store-purchases');

        Route::get('/reports/export/reward-redemptions', [ReportController::class, 'exportRewardRedemptionsCsv'])
            ->name('reports.export.reward-redemptions');

        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
    });

    Route::middleware(['role:toko_kios'])->prefix('toko')->name('toko.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'toko'])
            ->name('dashboard');

        Route::resource('customer-transactions', TokoCustomerTransactionController::class)
            ->only(['index', 'create', 'store', 'show']);

        Route::resource('store-purchases', TokoStorePurchaseTransactionController::class)
            ->only(['index', 'create', 'store', 'show']);

        Route::get('/point-histories', [TokoPointHistoryController::class, 'index'])
            ->name('point-histories.index');

        Route::resource('rewards', TokoRewardController::class)
            ->only(['index', 'show']);

        Route::post('/rewards/{reward}/redeem', [TokoRewardRedemptionController::class, 'store'])
            ->name('rewards.redeem');

        Route::resource('reward-redemptions', TokoRewardRedemptionController::class)
            ->only(['index', 'show']);
    });

    Route::middleware(['role:konsumen'])->prefix('konsumen')->name('konsumen.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'konsumen'])
            ->name('dashboard');

        Route::get('/point-histories', [KonsumenPointHistoryController::class, 'index'])
            ->name('point-histories.index');

        Route::resource('rewards', KonsumenRewardController::class)
            ->only(['index', 'show']);

        Route::post('/rewards/{reward}/redeem', [KonsumenRewardRedemptionController::class, 'store'])
            ->name('rewards.redeem');

        Route::resource('reward-redemptions', KonsumenRewardRedemptionController::class)
            ->only(['index', 'show']);
    });
});

require __DIR__.'/auth.php';
