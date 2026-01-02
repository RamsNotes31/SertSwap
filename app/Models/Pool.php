<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pool extends Model
{
    protected $fillable = [
        'pair_address',
        'token0_id',
        'token1_id',
        'chain_id',
        'reserve0',
        'reserve1',
        'tvl_usd',
        'volume_24h',
        'fee_percent',
        'is_active',
    ];

    protected $casts = [
        'chain_id'    => 'integer',
        'reserve0'    => 'decimal:18',
        'reserve1'    => 'decimal:18',
        'tvl_usd'     => 'decimal:2',
        'volume_24h'  => 'decimal:2',
        'fee_percent' => 'decimal:2',
        'is_active'   => 'boolean',
    ];

    /**
     * Get token0
     */
    public function token0(): BelongsTo
    {
        return $this->belongsTo(Token::class, 'token0_id');
    }

    /**
     * Get token1
     */
    public function token1(): BelongsTo
    {
        return $this->belongsTo(Token::class, 'token1_id');
    }

    /**
     * Get transactions for this pool
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope to filter by chain
     */
    public function scopeForChain($query, int $chainId)
    {
        return $query->where('chain_id', $chainId);
    }

    /**
     * Get pool name (e.g., "ETH/USDC")
     */
    public function getNameAttribute(): string
    {
        return $this->token0->symbol . '/' . $this->token1->symbol;
    }
}
