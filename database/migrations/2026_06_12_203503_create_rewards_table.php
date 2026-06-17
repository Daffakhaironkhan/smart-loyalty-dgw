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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('reward_code')->unique();
            $table->string('reward_name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('required_points')->default(0);
            $table->integer('stock')->default(0);
            $table->enum('redeemable_by', ['customer', 'store', 'both'])->default('customer');
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
