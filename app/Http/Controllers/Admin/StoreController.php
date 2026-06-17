<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('store_code', 'like', "%{$search}%")
                    ->orWhere('store_name', 'like', "%{$search}%")
                    ->orWhere('owner_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('area', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $stores = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => ['required', 'string', 'max:150'],
            'owner_name' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30', 'unique:users,phone'],
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->store_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            $user->assignRole('toko_kios');

            Store::create([
                'user_id' => $user->id,
                'store_code' => $this->generateStoreCode(),
                'store_name' => $request->store_name,
                'owner_name' => $request->owner_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'area' => $request->area,
                'total_points' => 0,
                'status' => $request->status,
            ]);
        });

        return redirect()
            ->route('admin.stores.index')
            ->with('success', 'Data Toko/Kios berhasil ditambahkan.');
    }

    public function show(Store $store)
    {
        $store->load('user');

        return view('admin.stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        $store->load('user');

        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => ['required', 'string', 'max:150'],
            'owner_name' => ['nullable', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($store->user_id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'phone')->ignore($store->user_id),
            ],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($store->user_id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        DB::transaction(function () use ($request, $store) {
            $userData = [
                'name' => $request->store_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'username' => $request->username,
                'status' => $request->status,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $store->user->update($userData);

            $store->update([
                'store_name' => $request->store_name,
                'owner_name' => $request->owner_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'area' => $request->area,
                'status' => $request->status,
            ]);
        });

        return redirect()
            ->route('admin.stores.index')
            ->with('success', 'Data Toko/Kios berhasil diperbarui.');
    }

    public function toggleStatus(Store $store)
    {
        $newStatus = $store->status === 'active' ? 'inactive' : 'active';

        DB::transaction(function () use ($store, $newStatus) {
            $store->update([
                'status' => $newStatus,
            ]);

            $store->user->update([
                'status' => $newStatus,
            ]);
        });

        return redirect()
            ->route('admin.stores.index')
            ->with('success', 'Status Toko/Kios berhasil diperbarui.');
    }

    public function destroy(Store $store)
    {
        DB::transaction(function () use ($store) {
            $store->user->delete();
            $store->delete();
        });

        return redirect()
            ->route('admin.stores.index')
            ->with('success', 'Data Toko/Kios berhasil dihapus.');
    }

    private function generateStoreCode(): string
    {
        $lastStore = Store::latest('id')->first();
        $nextNumber = $lastStore ? $lastStore->id + 1 : 1;

        return 'TK-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
