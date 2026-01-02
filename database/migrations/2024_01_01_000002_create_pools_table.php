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
        Schema::create('pools', function (Blueprint $table) {
            $table->id();
            $table->string('pair_address', 42);
            $table->foreignId('token0_id')->constrained('tokens')->onDelete('cascade');
            $table->foreignId('token1_id')->constrained('tokens')->onDelete('cascade');
            $table->unsignedBigInteger('chain_id');
            $table->decimal('reserve0', 36, 18)->default(0);
            $table->decimal('reserve1', 36, 18)->default(0);
            $table->decimal('tvl_usd', 20, 2)->default(0);
            $table->decimal('volume_24h', 20, 2)->default(0);
            $table->decimal('fee_percent', 5, 2)->default(0.3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['pair_address', 'chain_id']);
            $table->index('chain_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pools');
    }
};
