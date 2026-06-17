<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('point_rules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('point_program_id')
                ->constrained('point_programs')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->enum('transaction_type', ['customer_purchase', 'store_purchase']);
            $table->enum('recipient_type', ['customer', 'store']);

            $table->integer('point_per_item')->default(0);
            $table->integer('min_quantity')->default(1);
            $table->decimal('multiplier', 5, 2)->default(1.00);

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            $table->unique([
                'point_program_id',
                'product_id',
                'transaction_type',
                'recipient_type'
            ], 'unique_point_rule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_rules');
    }
};
