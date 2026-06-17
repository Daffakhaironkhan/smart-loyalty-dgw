<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\PointProgram;
use App\Models\PointRule;
use App\Models\Product;
use App\Models\StorePurchaseTransaction;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorePurchaseTransactionController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            abort(403, 'Akun ini tidak terhubung dengan data Toko/Kios.');
        }

        $transactions = StorePurchaseTransaction::with(['items.product'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('toko.store-purchases.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')
            ->orderBy('product_name')
            ->get();

        return view('toko.store-purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => ['nullable', 'string', 'max:100'],
            'transaction_date' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $store = auth()->user()->store;

        if (!$store) {
            abort(403, 'Akun ini tidak terhubung dengan data Toko/Kios.');
        }

        $product = Product::findOrFail($request->product_id);

        $quantity = (int) $request->quantity;
        $price = $product->price;
        $subtotal = $price * $quantity;

        $pointRule = $this->findPointRule($product->id, $quantity);

        if ($pointRule) {
            $storePoints = (int) (($pointRule->point_per_item * $quantity) * $pointRule->multiplier);
        } else {
            $storePoints = $product->base_store_point * $quantity;
        }

        DB::transaction(function () use ($request, $store, $product, $quantity, $price, $subtotal, $pointRule, $storePoints) {
            $transaction = StorePurchaseTransaction::create([
                'transaction_code' => $this->generateTransactionCode(),
                'store_id' => $store->id,
                'transaction_date' => $request->transaction_date,
                'invoice_number' => $request->invoice_number,
                'total_amount' => $subtotal,
                'total_store_points' => $storePoints,
                'status' => 'pending',
            ]);

            $transaction->items()->create([
                'product_id' => $product->id,
                'point_rule_id' => $pointRule?->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'store_points' => $storePoints,
            ]);

            $admins = User::role('admin')->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pengajuan Pembelian Baru',
                    'message' => 'Toko/Kios ' . $store->store_name . ' mengajukan pembelian ke DGW dengan kode ' . $transaction->transaction_code . '.',
                    'type' => 'store_purchase_requested',
                    'link' => route('admin.store-purchases.show', $transaction),
                ]);
            }
        });

        return redirect()
            ->route('toko.store-purchases.index')
            ->with('success', 'Transaksi pembelian ke DGW berhasil dibuat dan menunggu validasi admin.');
    }

    public function show(StorePurchaseTransaction $storePurchase)
    {
        $store = auth()->user()->store;

        if (!$store || $storePurchase->store_id !== $store->id) {
            abort(403);
        }

        $storePurchase->load(['store', 'items.product', 'items.pointRule']);

        return view('toko.store-purchases.show', compact('storePurchase'));
    }

    private function findPointRule(int $productId, int $quantity): ?PointRule
    {
        $today = now()->toDateString();

        $activeProgramIds = PointProgram::where('status', 'active')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->pluck('id');

        return PointRule::whereIn('point_program_id', $activeProgramIds)
            ->where('product_id', $productId)
            ->where('transaction_type', 'store_purchase')
            ->where('recipient_type', 'store')
            ->where('status', 'active')
            ->where('min_quantity', '<=', $quantity)
            ->orderByDesc('min_quantity')
            ->first();
    }

    private function generateTransactionCode(): string
    {
        $lastTransaction = StorePurchaseTransaction::latest('id')->first();
        $nextNumber = $lastTransaction ? $lastTransaction->id + 1 : 1;

        return 'SP-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
