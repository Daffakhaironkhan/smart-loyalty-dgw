<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\PointProgram;
use App\Models\PointRule;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Reward;
use App\Models\RewardRedemption;
use App\Models\Store;
use App\Models\StorePurchaseTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $storeRole = Role::firstOrCreate([
            'name' => 'toko_kios',
            'guard_name' => 'web',
        ]);

        $customerRole = Role::firstOrCreate([
            'name' => 'konsumen',
            'guard_name' => 'web',
        ]);

        $admin = User::updateOrCreate(
            ['username' => 'admin_dgw'],
            [
                'name' => 'Admin DGW',
                'email' => 'admin@dgw.test',
                'phone' => '081100000001',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );
        $admin->syncRoles([$adminRole]);

        $storeUser = User::updateOrCreate(
            ['username' => 'toko_sumber'],
            [
                'name' => 'Toko Sumber Makmur',
                'email' => 'toko@dgw.test',
                'phone' => '081100000002',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );
        $storeUser->syncRoles([$storeRole]);

        $customerUser = User::updateOrCreate(
            ['username' => 'budi_santoso'],
            [
                'name' => 'Budi Santoso',
                'email' => 'konsumen@dgw.test',
                'phone' => '081100000003',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );
        $customerUser->syncRoles([$customerRole]);

        $store = Store::updateOrCreate(
            ['store_code' => 'TK-001'],
            [
                'user_id' => $storeUser->id,
                'store_name' => 'Toko Sumber Makmur',
                'owner_name' => 'Sumber Makmur',
                'phone' => '081100000002',
                'email' => 'toko@dgw.test',
                'address' => 'Jl. Raya Demo No. 1',
                'city' => 'Cirebon',
                'area' => 'Cirebon Timur',
                'total_points' => 500,
                'status' => 'active',
            ]
        );

        $customer = Customer::updateOrCreate(
            ['member_code' => 'MB-001'],
            [
                'user_id' => $customerUser->id,
                'name' => 'Budi Santoso',
                'phone' => '081100000003',
                'email' => 'konsumen@dgw.test',
                'address' => 'Jl. Konsumen Demo No. 2',
                'birth_date' => '1999-01-01',
                'gender' => 'male',
                'total_points' => 300,
                'membership_level' => 'Silver',
                'status' => 'active',
                'registered_by_store_id' => $store->id,
            ]
        );

        $category = ProductCategory::updateOrCreate(
            ['name' => 'Pupuk'],
            [
                'description' => 'Kategori produk pupuk DGW.',
                'status' => 'active',
            ]
        );

        $product = Product::updateOrCreate(
            ['product_code' => 'PRD-001'],
            [
                'product_category_id' => $category->id,
                'product_name' => 'DGW Super Fertilizer',
                'description' => 'Produk pupuk unggulan untuk kebutuhan demo sistem.',
                'price' => 150000,
                'base_customer_point' => 25,
                'base_store_point' => 50,
                'stock' => 100,
                'status' => 'active',
            ]
        );

        $program = PointProgram::updateOrCreate(
            ['program_name' => 'Program Poin Demo 2026'],
            [
                'description' => 'Program poin demo untuk transaksi konsumen dan pembelian toko.',
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
                'created_by' => $admin->id,
            ]
        );

        $customerRule = PointRule::updateOrCreate(
            [
                'point_program_id' => $program->id,
                'product_id' => $product->id,
                'transaction_type' => 'customer_purchase',
                'recipient_type' => 'customer',
            ],
            [
                'point_per_item' => 25,
                'min_quantity' => 1,
                'multiplier' => 1,
                'status' => 'active',
            ]
        );

        $storeRule = PointRule::updateOrCreate(
            [
                'point_program_id' => $program->id,
                'product_id' => $product->id,
                'transaction_type' => 'store_purchase',
                'recipient_type' => 'store',
            ],
            [
                'point_per_item' => 50,
                'min_quantity' => 1,
                'multiplier' => 1,
                'status' => 'active',
            ]
        );

        $reward = Reward::updateOrCreate(
            ['reward_code' => 'RWD-001'],
            [
                'reward_name' => 'Voucher Belanja 50K',
                'description' => 'Reward demo berupa voucher belanja.',
                'required_points' => 100,
                'stock' => 20,
                'redeemable_by' => 'both',
                'status' => 'active',
                'created_by' => $admin->id,
            ]
        );

        $customerTransaction = CustomerTransaction::updateOrCreate(
            ['transaction_code' => 'CT-20260612-00001'],
            [
                'store_id' => $store->id,
                'customer_id' => $customer->id,
                'transaction_date' => '2026-06-12',
                'total_amount' => 150000,
                'total_customer_points' => 25,
                'status' => 'pending',
            ]
        );

        $customerTransaction->items()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'point_rule_id' => $customerRule->id,
                'quantity' => 1,
                'price' => 150000,
                'subtotal' => 150000,
                'customer_points' => 25,
            ]
        );

        $approvedCustomerTransaction = CustomerTransaction::updateOrCreate(
            ['transaction_code' => 'CT-20260612-00002'],
            [
                'store_id' => $store->id,
                'customer_id' => $customer->id,
                'transaction_date' => '2026-06-12',
                'total_amount' => 300000,
                'total_customer_points' => 50,
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ]
        );

        $approvedCustomerTransaction->items()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'point_rule_id' => $customerRule->id,
                'quantity' => 2,
                'price' => 150000,
                'subtotal' => 300000,
                'customer_points' => 50,
            ]
        );

        $storePurchase = StorePurchaseTransaction::updateOrCreate(
            ['transaction_code' => 'SP-20260612-00001'],
            [
                'store_id' => $store->id,
                'transaction_date' => '2026-06-12',
                'invoice_number' => 'INV-DGW-001',
                'total_amount' => 150000,
                'total_store_points' => 50,
                'status' => 'pending',
            ]
        );

        $storePurchase->items()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'point_rule_id' => $storeRule->id,
                'quantity' => 1,
                'price' => 150000,
                'subtotal' => 150000,
                'store_points' => 50,
            ]
        );

        $approvedStorePurchase = StorePurchaseTransaction::updateOrCreate(
            ['transaction_code' => 'SP-20260612-00002'],
            [
                'store_id' => $store->id,
                'transaction_date' => '2026-06-12',
                'invoice_number' => 'INV-DGW-002',
                'total_amount' => 450000,
                'total_store_points' => 150,
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ]
        );

        $approvedStorePurchase->items()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'point_rule_id' => $storeRule->id,
                'quantity' => 3,
                'price' => 150000,
                'subtotal' => 450000,
                'store_points' => 150,
            ]
        );

        RewardRedemption::updateOrCreate(
            ['redemption_code' => 'RR-20260612-00001'],
            [
                'user_id' => $storeUser->id,
                'reward_id' => $reward->id,
                'points_used' => 100,
                'status' => 'requested',
                'redeemed_at' => now(),
            ]
        );
    }
}
