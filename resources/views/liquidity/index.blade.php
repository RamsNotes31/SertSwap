@extends('layouts.app')

@section('title', 'Liquidity')

@section('content')
<div style="display: flex; justify-content: center; padding-top: 20px;">
    <div style="width: 100%; max-width: 500px;">
        <!-- Tab Selector -->
        <div class="flex gap-2 mb-4">
            <button id="tabAdd" class="tab-btn active" onclick="switchTab('add')">Add Liquidity</button>
            <button id="tabRemove" class="tab-btn" onclick="switchTab('remove')">Remove Liquidity</button>
        </div>

        <!-- Add Liquidity Card -->
        <div class="glass-card p-6" id="addLiquidityCard">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="gradient-text" style="font-size: 1.5rem; font-weight: 700;">Add Liquidity</h2>
                <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); padding: 6px 12px; border-radius: 100px;">
                    <span style="font-size: 0.8rem; font-weight: 600; color: var(--success);">Earn 0.3% fees</span>
                </div>
            </div>

            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 20px;">
                Provide liquidity to earn trading fees from every swap.
            </p>

            <!-- Token A -->
            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 16px; padding: 16px; margin-bottom: 8px;">
                <div class="flex items-center justify-between mb-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Token A</span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Balance: <span id="tokenABalance" style="color: var(--text-secondary);">0.00</span></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <input type="text"
                           id="tokenAAmount"
                           class="input-dark"
                           placeholder="0.0"
                           oninput="onTokenAChange()"
                           style="background: transparent; border: none; padding: 0; font-size: 1.8rem;">
                    <div class="token-selector" id="tokenASelector" onclick="selectTokenA()">
                        <img id="tokenALogo" src="/images/tokens/eth.svg" alt="Token" onerror="this.style.display='none'">
                        <span id="tokenASymbol">ETH</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Plus Icon -->
            <div style="display: flex; justify-content: center; margin: -6px 0; position: relative; z-index: 10;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: 3px solid var(--bg-dark); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-size: 1.3rem; font-weight: 700;">+</span>
                </div>
            </div>

            <!-- Token B -->
            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 16px; padding: 16px; margin-top: 8px;">
                <div class="flex items-center justify-between mb-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Token B</span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Balance: <span id="tokenBBalance" style="color: var(--text-secondary);">0.00</span></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <input type="text"
                           id="tokenBAmount"
                           class="input-dark"
                           placeholder="0.0"
                           readonly
                           style="background: transparent; border: none; padding: 0; font-size: 1.8rem; opacity: 0.8;">
                    <div class="token-selector" id="tokenBSelector" onclick="selectTokenB()">
                        <img id="tokenBLogo" src="/images/tokens/usdc.svg" alt="Token" onerror="this.style.display='none'">
                        <span id="tokenBSymbol">Select</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pool Info -->
            <div id="poolInfo" class="mt-4" style="display: none;">
                <div style="background: var(--bg-input); border-radius: 12px; padding: 14px;">
                    <div class="flex items-center justify-between mb-3">
                        <h4 style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary);">Pool Information</h4>
                        <span id="poolStatus" style="font-size: 0.75rem; font-weight: 600; color: var(--success); background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 100px;">Active</span>
                    </div>
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Your LP Tokens</span>
                        <span id="userLpTokens" style="color: var(--text-secondary);">0.0000</span>
                    </div>
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Pool Share</span>
                        <span id="poolShare" style="color: var(--primary-light);">0%</span>
                    </div>
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);"><span id="poolToken0">-</span> per <span id="poolToken1">-</span></span>
                        <span id="poolRate" style="color: var(--text-secondary);">-</span>
                    </div>
                    <div class="flex items-center justify-between" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Total Value</span>
                        <span id="totalValue" style="color: var(--success);">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <button id="liquidityBtn" class="btn-primary w-full mt-6" onclick="addLiquidity()" disabled>
                <span id="liquidityBtnText">Select tokens</span>
            </button>
        </div>

        <!-- Remove Liquidity Card -->
        <div class="glass-card p-6" id="removeLiquidityCard" style="display: none;">
            <div class="flex items-center justify-between mb-6">
                <h2 class="gradient-text" style="font-size: 1.5rem; font-weight: 700;">Remove Liquidity</h2>
            </div>

            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 20px;">
                Remove your liquidity and receive tokens back.
            </p>

            <div id="yourPositions">
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="width: 60px; height: 60px; background: var(--bg-input); border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2">
                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <path d="M9 12h6"/>
                        </svg>
                    </div>
                    <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">No positions found</p>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Connect wallet to view your liquidity positions</p>
                </div>
            </div>
        </div>

        <!-- Top Pools -->
        <div class="glass-card p-4 mt-4">
            <div class="flex items-center justify-between mb-4">
                <h3 style="font-size: 1rem; font-weight: 600; color: var(--text-primary);">Top Pools</h3>
                <span style="font-size: 0.85rem; color: var(--primary-light); cursor: pointer;">View All →</span>
            </div>
            <div id="poolsList">
                @if($pools->isEmpty())
                    <div style="text-align: center; padding: 30px 0;">
                        <p style="color: var(--text-muted);">No active pools on this chain</p>
                        <p style="font-size: 0.85rem; color: var(--primary-light); margin-top: 8px;">Be the first to create one!</p>
                    </div>
                @else
                    @foreach($pools as $pool)
                    <div class="pool-item">
                        <div class="flex items-center gap-2" style="gap: 12px;">
                            <div style="display: flex;">
                                <img src="{{ $pool->token0->logo_url ?? '/images/tokens/default.svg' }}" alt="{{ $pool->token0->symbol }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--bg-dark);">
                                <img src="{{ $pool->token1->logo_url ?? '/images/tokens/default.svg' }}" alt="{{ $pool->token1->symbol }}" style="width: 32px; height: 32px; border-radius: 50%; margin-left: -10px; border: 2px solid var(--bg-dark);">
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.95rem;">{{ $pool->token0->symbol }}/{{ $pool->token1->symbol }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Fee: {{ $pool->fee_percent }}%</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600; color: var(--success);">${{ number_format($pool->tvl_usd, 0) }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">TVL</div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .tab-btn {
        flex: 1;
        padding: 12px 20px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Space Grotesk', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .tab-btn:hover {
        border-color: var(--primary);
        color: var(--text-primary);
    }
    .tab-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: transparent;
        color: white;
    }
    .pool-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .pool-item:hover {
        background: rgba(99, 102, 241, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    // Liquidity State
    const liquidityState = {
        tokenA: null,
        tokenB: null,
        tokenAAmount: '',
        tokenBAmount: '',
        poolInfo: null,
    };

    // Initialize with default tokens
    document.addEventListener('DOMContentLoaded', () => {
        const tokens = SertiDex.tokens;
        if (tokens.length > 0) {
            const nativeToken = tokens.find(t => t.is_native) || tokens[0];
            setTokenA(nativeToken);

            if (tokens.length > 1) {
                const secondToken = tokens.find(t => !t.is_native && t.symbol === 'USDC') || tokens.find(t => !t.is_native) || tokens[1];
                setTokenB(secondToken);
            }
        }
    });

    function switchTab(tab) {
        document.getElementById('tabAdd').classList.toggle('active', tab === 'add');
        document.getElementById('tabRemove').classList.toggle('active', tab === 'remove');
        document.getElementById('addLiquidityCard').style.display = tab === 'add' ? 'block' : 'none';
        document.getElementById('removeLiquidityCard').style.display = tab === 'remove' ? 'block' : 'none';
    }

    function selectTokenA() {
        openTokenModal((token) => {
            if (token.address !== liquidityState.tokenB?.address) {
                setTokenA(token);
                onTokenAChange();
            }
        });
    }

    function selectTokenB() {
        openTokenModal((token) => {
            if (token.address !== liquidityState.tokenA?.address) {
                setTokenB(token);
                onTokenAChange();
            }
        });
    }

    function setTokenA(token) {
        liquidityState.tokenA = token;
        document.getElementById('tokenASymbol').textContent = token.symbol;
        document.getElementById('tokenALogo').src = token.logo_url || '/images/tokens/default.svg';
        document.getElementById('tokenABalance').textContent = SertiDex.balances[token.symbol] || '0.00';
        updateLiquidityButton();
    }

    function setTokenB(token) {
        liquidityState.tokenB = token;
        document.getElementById('tokenBSymbol').textContent = token.symbol;
        document.getElementById('tokenBLogo').src = token.logo_url || '/images/tokens/default.svg';
        document.getElementById('tokenBBalance').textContent = SertiDex.balances[token.symbol] || '0.00';
        updateLiquidityButton();
    }

    let quoteTimeout = null;
    async function onTokenAChange() {
        const amount = document.getElementById('tokenAAmount').value;
        liquidityState.tokenAAmount = amount;

        if (quoteTimeout) clearTimeout(quoteTimeout);

        if (amount && parseFloat(amount) > 0 && liquidityState.tokenA && liquidityState.tokenB) {
            quoteTimeout = setTimeout(getAddQuote, 500);
        } else {
            document.getElementById('tokenBAmount').value = '';
            document.getElementById('poolInfo').style.display = 'none';
        }

        updateLiquidityButton();
    }

    async function getAddQuote() {
        if (!liquidityState.tokenA || !liquidityState.tokenB || !liquidityState.tokenAAmount) return;

        try {
            const response = await fetch('{{ route("liquidity.add-quote") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    chain_id: SertiDex.currentChainId,
                    token0: liquidityState.tokenA.address,
                    token1: liquidityState.tokenB.address,
                    amount0: liquidityState.tokenAAmount,
                }),
            });

            const data = await response.json();

            liquidityState.tokenBAmount = data.amount1;
            document.getElementById('tokenBAmount').value = parseFloat(data.amount1).toFixed(6);

            document.getElementById('poolInfo').style.display = 'block';
            document.getElementById('poolToken0').textContent = liquidityState.tokenA.symbol;
            document.getElementById('poolToken1').textContent = liquidityState.tokenB.symbol;
            document.getElementById('poolRate').textContent = (parseFloat(data.amount1) / parseFloat(data.amount0)).toFixed(4);
            document.getElementById('totalValue').textContent = '$' + data.total_value_usd;
            document.getElementById('poolShare').textContent = data.share_of_pool;
            document.getElementById('userLpTokens').textContent = data.estimated_lp;

            updateLiquidityButton();
        } catch (error) {
            console.error('Quote error:', error);
        }
    }

    function updateLiquidityButton() {
        const btn = document.getElementById('liquidityBtn');
        const text = document.getElementById('liquidityBtnText');

        if (!SertiDex.wallet) {
            btn.disabled = true;
            text.textContent = 'Connect Wallet';
            btn.onclick = () => document.getElementById('walletBtn').click();
            return;
        }

        btn.onclick = addLiquidity;

        if (!liquidityState.tokenA || !liquidityState.tokenB) {
            btn.disabled = true;
            text.textContent = 'Select tokens';
            return;
        }

        if (!liquidityState.tokenAAmount || parseFloat(liquidityState.tokenAAmount) <= 0) {
            btn.disabled = true;
            text.textContent = 'Enter amount';
            return;
        }

        btn.disabled = false;
        text.textContent = 'Add Liquidity';
    }

    async function addLiquidity() {
        if (!SertiDex.wallet) return;

        const btn = document.getElementById('liquidityBtn');
        const text = document.getElementById('liquidityBtnText');

        btn.disabled = true;
        text.innerHTML = '<span class="spinner"></span> Adding Liquidity...';

        setTimeout(() => {
            showToast(`Added ${liquidityState.tokenAAmount} ${liquidityState.tokenA.symbol} + ${parseFloat(liquidityState.tokenBAmount).toFixed(4)} ${liquidityState.tokenB.symbol} to pool!`, 'success');

            document.getElementById('tokenAAmount').value = '';
            document.getElementById('tokenBAmount').value = '';
            liquidityState.tokenAAmount = '';
            liquidityState.tokenBAmount = '';
            document.getElementById('poolInfo').style.display = 'none';
            updateLiquidityButton();
        }, 2000);
    }
</script>
@endsection
