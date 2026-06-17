<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\PointProgram;
use App\Models\PointRule;
use App\Models\Product;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerTransactionController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $transactions = CustomerTransaction::with(['customer', 'items.product'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('toko.customer-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $store = auth()->user()->store;

        $customers = Customer::where('status', 'active')
            ->where(function ($query) use ($store) {
                $query->whereNull('registered_by_store_id')
                    ->orWhere('registered_by_store_id', $store->id);
            })
            ->orderBy('name')
            ->get();

        $products = Product::where('status', 'active')
            ->orderBy('product_name')
            ->get();

        return view('toko.customer-transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
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
            $customerPoints = (int) (($pointRule->point_per_item * $quantity) * $pointRule->multiplier);
        } else {
            $customerPoints = $product->base_customer_point * $quantity;
        }

        DB::transaction(function () use ($request, $store, $product, $quantity, $price, $subtotal, $pointRule, $customerPoints) {
            $transaction = CustomerTransaction::create([
                'transaction_code' => $this->generateTransactionCode(),
                'store_id' => $store->id,
                'customer_id' => $request->customer_id,
                'transaction_date' => $request->transaction_date,
                'total_amount' => $subtotal,
                'total_customer_points' => $customerPoints,
                'status' => 'pending',
            ]);

            $transaction->items()->create([
                'product_id' => $product->id,
                'point_rule_id' => $pointRule?->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'customer_points' => $customerPoints,
            ]);

            $admins = User::role('admin')->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Transaksi Konsumen Baru',
                    'message' => 'Toko/Kios ' . $store->store_name . ' membuat transaksi konsumen baru dengan kode ' . $transaction->transaction_code . '.',
                    'type' => 'customer_transaction_requested',
                    'link' => route('admin.customer-transactions.show', $transaction),
                ]);
            }
        });

        return redirect()
            ->route('toko.customer-transactions.index')
            ->with('success', 'Transaksi konsumen berhasil dibuat dan menunggu validasi admin.');
    }

    public function show(CustomerTransaction $customerTransaction)
    {
        $store = auth()->user()->store;

        if ($customerTransaction->store_id !== $store->id) {
            abort(403);
        }

        $customerTransaction->load(['customer', 'store', 'items.product', 'items.pointRule']);

        return view('toko.customer-transactions.show', compact('customerTransaction'));
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
            ->where('transaction_type', 'customer_purchase')
            ->where('recipient_type', 'customer')
            ->where('status', 'active')
            ->where('min_quantity', '<=', $quantity)
            ->orderByDesc('min_quantity')
            ->first();
    }

    private function generateTransactionCode(): string
    {
        $lastTransaction = CustomerTransaction::latest('id')->first();
        $nextNumber = $lastTransaction ? $lastTransaction->id + 1 : 1;

        return 'CT-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
