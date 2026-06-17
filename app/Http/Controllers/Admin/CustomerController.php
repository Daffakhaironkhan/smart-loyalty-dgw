<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'registeredByStore']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('member_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('membership_level', 'like', "%{$search}%")
                    ->orWhereHas('registeredByStore', function ($storeQuery) use ($search) {
                        $storeQuery->where('store_name', 'like', "%{$search}%")
                            ->orWhere('store_code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $customers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        $stores = Store::where('status', 'active')
            ->orderBy('store_name')
            ->get();

        return view('admin.customers.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30', 'unique:users,phone'],
            'username' => ['nullable', 'string', 'max:100', 'unique:users,username'],
            'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'membership_level' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'registered_by_store_id' => ['nullable', 'exists:stores,id'],
        ]);

        DB::transaction(function () use ($request) {
            $user = null;

            if ($request->filled('email') && $request->filled('username') && $request->filled('password')) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'status' => $request->status,
                ]);

                $user->assignRole('konsumen');
            }

            Customer::create([
                'user_id' => $user?->id,
                'member_code' => $this->generateMemberCode(),
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'total_points' => 0,
                'membership_level' => $request->membership_level ?? 'Silver',
                'status' => $request->status,
                'registered_by_store_id' => $request->registered_by_store_id,
            ]);
        });

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data konsumen berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['user', 'registeredByStore']);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $customer->load('user');

        $stores = Store::where('status', 'active')
            ->orderBy('store_name')
            ->get();

        return view('admin.customers.edit', compact('customer', 'stores'));
    }

    public function update(Request $request, Customer $customer)
    {
        $userId = $customer->user_id;

        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'username' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'membership_level' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
            'registered_by_store_id' => ['nullable', 'exists:stores,id'],
        ]);

        DB::transaction(function () use ($request, $customer) {
            if ($customer->user) {
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'username' => $request->username,
                    'status' => $request->status,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $customer->user->update($userData);
            }

            $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'membership_level' => $request->membership_level ?? 'Silver',
                'status' => $request->status,
                'registered_by_store_id' => $request->registered_by_store_id,
            ]);
        });

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data konsumen berhasil diperbarui.');
    }

    public function toggleStatus(Customer $customer)
    {
        $newStatus = $customer->status === 'active' ? 'inactive' : 'active';

        DB::transaction(function () use ($customer, $newStatus) {
            $customer->update([
                'status' => $newStatus,
            ]);

            if ($customer->user) {
                $customer->user->update([
                    'status' => $newStatus,
                ]);
            }
        });

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Status konsumen berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        DB::transaction(function () use ($customer) {
            if ($customer->user) {
                $customer->user->delete();
            }

            $customer->delete();
        });

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data konsumen berhasil dihapus.');
    }

    private function generateMemberCode(): string
    {
        $lastCustomer = Customer::latest('id')->first();
        $nextNumber = $lastCustomer ? $lastCustomer->id + 1 : 1;

        return 'MBR-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
