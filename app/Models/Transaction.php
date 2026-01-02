<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'tx_hash',
        'wallet_address',
        'type',
        'chain_id',
        'token_in_id',
        'token_out_id',
        'amount_in',
        'amount_out',
        'pool_id',
        'amount0',
        'amount1',
        'lp_tokens',
        'value_usd',
        'status',
        'confirmed_at',
    ];

    protected $casts = [
        'chain_id'     => 'integer',
        'amount_in'    => 'decimal:18',
        'amount_out'   => 'decimal:18',
        'amount0'      => 'decimal:18',
        'amount1'      => 'decimal:18',
        'lp_tokens'    => 'decimal:18',
        'value_usd'    => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    /**
     * Get token in (for swaps)
     */
    public function tokenIn(): BelongsTo
    {
        return $this->belongsTo(Token::class, 'token_in_id');
    }

    /**
     * Get token out (for swaps)
     */
    public function tokenOut(): BelongsTo
    {
        return $this->belongsTo(Token::class, 'token_out_id');
    }

    /**
     * Get pool (for liquidity operations)
     */
    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }

    /**
     * Scope to filter by wallet
     */
    public function scopeForWallet($query, string $wallet)
    {
        return $query->where('wallet_address', strtolower($wallet));
    }

    /**
     * Scope to filter by chain
     */
    public function scopeForChain($query, int $chainId)
    {
        return $query->where('chain_id', $chainId);
    }

    /**
     * Get explorer URL for transaction
     */
    public function getExplorerUrlAttribute(): string
    {
        foreach (config('chains') as $chain) {
            if (isset($chain['chain_id']) && $chain['chain_id'] === $this->chain_id) {
                return $chain['explorer'] . '/tx/' . $this->tx_hash;
            }
        }
        return '#';
    }
}
