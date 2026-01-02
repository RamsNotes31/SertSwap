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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tx_hash', 66)->unique();
            $table->string('wallet_address', 42);
            $table->enum('type', ['swap', 'add_liquidity', 'remove_liquidity']);
            $table->unsignedBigInteger('chain_id');

            // For swaps
            $table->foreignId('token_in_id')->nullable()->constrained('tokens');
            $table->foreignId('token_out_id')->nullable()->constrained('tokens');
            $table->decimal('amount_in', 36, 18)->nullable();
            $table->decimal('amount_out', 36, 18)->nullable();

            // For liquidity
            $table->foreignId('pool_id')->nullable()->constrained('pools');
            $table->decimal('amount0', 36, 18)->nullable();
            $table->decimal('amount1', 36, 18)->nullable();
            $table->decimal('lp_tokens', 36, 18)->nullable();

            $table->decimal('value_usd', 20, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index('wallet_address');
            $table->index('chain_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
