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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 20);
            $table->string('name', 100);
            $table->string('address', 42);
            $table->unsignedTinyInteger('decimals')->default(18);
            $table->unsignedBigInteger('chain_id');
            $table->string('logo_url')->nullable();
            $table->boolean('is_native')->default(false);
            $table->boolean('is_wrapped_native')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('price_usd', 20, 8)->nullable();
            $table->timestamps();

            $table->unique(['address', 'chain_id']);
            $table->index('chain_id');
            $table->index('symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
