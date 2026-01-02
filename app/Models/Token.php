<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Token extends Model
{
    protected $fillable = [
        'symbol',
        'name',
        'address',
        'decimals',
        'chain_id',
        'logo_url',
        'is_native',
        'is_wrapped_native',
        'is_active',
        'price_usd',
    ];

    protected $casts = [
        'decimals'          => 'integer',
        'chain_id'          => 'integer',
        'is_native'         => 'boolean',
        'is_wrapped_native' => 'boolean',
        'is_active'         => 'boolean',
        'price_usd'         => 'decimal:8',
    ];

    /**
     * Get pools where this token is token0
     */
    public function poolsAsToken0(): HasMany
    {
        return $this->hasMany(Pool::class, 'token0_id');
    }

    /**
     * Get pools where this token is token1
     */
    public function poolsAsToken1(): HasMany
    {
        return $this->hasMany(Pool::class, 'token1_id');
    }

    /**
     * Scope to filter by chain
     */
    public function scopeForChain($query, int $chainId)
    {
        return $query->where('chain_id', $chainId);
    }

    /**
     * Scope to get active tokens
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get chain configuration
     */
    public function getChainConfigAttribute(): ?array
    {
        foreach (config('chains') as $key => $chain) {
            if (isset($chain['chain_id']) && $chain['chain_id'] === $this->chain_id) {
                return $chain;
            }
        }
        return null;
    }
}
