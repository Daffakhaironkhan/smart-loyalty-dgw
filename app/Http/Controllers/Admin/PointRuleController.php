<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointProgram;
use App\Models\PointRule;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PointRuleController extends Controller
{
    public function index()
    {
        $query = PointRule::with(['program', 'product'])
            ->latest();

        if (request('program_id')) {
            $query->where('point_program_id', request('program_id'));
        }

        if (request('product_id')) {
            $query->where('product_id', request('product_id'));
        }

        if (request('transaction_type')) {
            $query->where('transaction_type', request('transaction_type'));
        }

        if (request('recipient_type')) {
            $query->where('recipient_type', request('recipient_type'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $rules = $query->paginate(10)->withQueryString();

        $programs = PointProgram::orderBy('program_name')->get();
        $products = Product::orderBy('product_name')->get();

        return view('admin.point-rules.index', compact(
            'rules',
            'programs',
            'products'
        ));
    }

    public function create()
    {
        $programs = PointProgram::where('status', 'active')
            ->orderBy('program_name')
            ->get();

        $products = Product::where('status', 'active')
            ->orderBy('product_name')
            ->get();

        return view('admin.point-rules.create', compact('programs', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'point_program_id' => ['required', 'exists:point_programs,id'],
            'product_id' => ['required', 'exists:products,id'],
            'transaction_type' => ['required', 'in:customer_purchase,store_purchase'],
            'recipient_type' => ['required', 'in:customer,store'],
            'point_per_item' => ['required', 'integer', 'min:0'],
            'min_quantity' => ['required', 'integer', 'min:1'],
            'multiplier' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if (
            $request->transaction_type === 'customer_purchase'
            && $request->recipient_type !== 'customer'
        ) {
            return back()
                ->withErrors(['recipient_type' => 'Transaksi konsumen hanya dapat memberikan poin kepada konsumen.'])
                ->withInput();
        }

        if (
            $request->transaction_type === 'store_purchase'
            && $request->recipient_type !== 'store'
        ) {
            return back()
                ->withErrors(['recipient_type' => 'Transaksi pembelian Toko/Kios ke DGW hanya dapat memberikan poin kepada Toko/Kios.'])
                ->withInput();
        }

        $exists = PointRule::where('point_program_id', $request->point_program_id)
            ->where('product_id', $request->product_id)
            ->where('transaction_type', $request->transaction_type)
            ->where('recipient_type', $request->recipient_type)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['product_id' => 'Aturan poin untuk produk, program, jenis transaksi, dan penerima poin ini sudah ada.'])
                ->withInput();
        }

        PointRule::create($request->only([
            'point_program_id',
            'product_id',
            'transaction_type',
            'recipient_type',
            'point_per_item',
            'min_quantity',
            'multiplier',
            'status',
        ]));

        return redirect()
            ->route('admin.point-rules.index')
            ->with('success', 'Aturan poin berhasil ditambahkan.');
    }

    public function edit(PointRule $pointRule)
    {
        $programs = PointProgram::orderBy('program_name')->get();
        $products = Product::orderBy('product_name')->get();

        return view('admin.point-rules.edit', compact('pointRule', 'programs', 'products'));
    }

    public function update(Request $request, PointRule $pointRule)
    {
        $request->validate([
            'point_program_id' => ['required', 'exists:point_programs,id'],
            'product_id' => ['required', 'exists:products,id'],
            'transaction_type' => ['required', 'in:customer_purchase,store_purchase'],
            'recipient_type' => ['required', 'in:customer,store'],
            'point_per_item' => ['required', 'integer', 'min:0'],
            'min_quantity' => ['required', 'integer', 'min:1'],
            'multiplier' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if (
            $request->transaction_type === 'customer_purchase'
            && $request->recipient_type !== 'customer'
        ) {
            return back()
                ->withErrors(['recipient_type' => 'Transaksi konsumen hanya dapat memberikan poin kepada konsumen.'])
                ->withInput();
        }

        if (
            $request->transaction_type === 'store_purchase'
            && $request->recipient_type !== 'store'
        ) {
            return back()
                ->withErrors(['recipient_type' => 'Transaksi pembelian Toko/Kios ke DGW hanya dapat memberikan poin kepada Toko/Kios.'])
                ->withInput();
        }

        $exists = PointRule::where('point_program_id', $request->point_program_id)
            ->where('product_id', $request->product_id)
            ->where('transaction_type', $request->transaction_type)
            ->where('recipient_type', $request->recipient_type)
            ->where('id', '!=', $pointRule->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['product_id' => 'Aturan poin untuk produk, program, jenis transaksi, dan penerima poin ini sudah ada.'])
                ->withInput();
        }

        $pointRule->update($request->only([
            'point_program_id',
            'product_id',
            'transaction_type',
            'recipient_type',
            'point_per_item',
            'min_quantity',
            'multiplier',
            'status',
        ]));

        return redirect()
            ->route('admin.point-rules.index')
            ->with('success', 'Aturan poin berhasil diperbarui.');
    }

    public function destroy(PointRule $pointRule)
    {
        $pointRule->delete();

        return redirect()
            ->route('admin.point-rules.index')
            ->with('success', 'Aturan poin berhasil dihapus.');
    }
}
