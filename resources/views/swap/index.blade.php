@extends('layouts.app')

@section('title', 'Swap')

@section('content')
<div style="display: flex; justify-content: center; padding-top: 20px;">
    <div style="width: 100%; max-width: 460px;">
        <!-- Swap Card -->
        <div class="glass-card p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="gradient-text" style="font-size: 1.5rem; font-weight: 700;">Swap</h2>
                <button onclick="openSettings()" style="background: var(--bg-card-hover); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px; cursor: pointer; color: var(--text-secondary); transition: all 0.2s;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </button>
            </div>

            <!-- From Token -->
            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 16px; padding: 16px;">
                <div class="flex items-center justify-between mb-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">You Pay</span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Balance: <span id="fromBalance" style="color: var(--text-secondary);">0.00</span></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <input type="text"
                           id="fromAmount"
                           class="input-dark"
                           placeholder="0.0"
                           oninput="onAmountChange()"
                           style="background: transparent; border: none; padding: 0; font-size: 2rem;">
                    <div class="token-selector" id="fromTokenSelector" onclick="selectFromToken()">
                        <img id="fromTokenLogo" src="/images/tokens/eth.svg" alt="Token" onerror="this.style.display='none'">
                        <span id="fromTokenSymbol">ETH</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">~$<span id="fromValueUsd">0.00</span></span>
                    <div class="flex gap-2">
                        <button onclick="setPercentage(25)" class="quick-btn">25%</button>
                        <button onclick="setPercentage(50)" class="quick-btn">50%</button>
                        <button onclick="setPercentage(75)" class="quick-btn">75%</button>
                        <button onclick="setPercentage(100)" class="quick-btn">MAX</button>
                    </div>
                </div>
            </div>

            <!-- Swap Direction Button -->
            <div style="display: flex; justify-content: center;">
                <button class="swap-arrow" onclick="swapDirection()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M7 10l5 5 5-5"/>
                        <path d="M7 6l5 5 5-5"/>
                    </svg>
                </button>
            </div>

            <!-- To Token -->
            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 16px; padding: 16px;">
                <div class="flex items-center justify-between mb-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">You Receive</span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Balance: <span id="toBalance" style="color: var(--text-secondary);">0.00</span></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <input type="text"
                           id="toAmount"
                           class="input-dark"
                           placeholder="0.0"
                           readonly
                           style="background: transparent; border: none; padding: 0; font-size: 2rem; opacity: 0.8;">
                    <div class="token-selector" id="toTokenSelector" onclick="selectToToken()">
                        <img id="toTokenLogo" src="/images/tokens/usdc.svg" alt="Token" onerror="this.style.display='none'">
                        <span id="toTokenSymbol">Select</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">~$<span id="toValueUsd">0.00</span></span>
                </div>
            </div>

            <!-- Swap Details -->
            <div id="swapDetails" class="mt-4" style="display: none;">
                <div style="background: var(--bg-input); border-radius: 12px; padding: 14px;">
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Rate</span>
                        <span id="swapRate" style="color: var(--text-secondary);">-</span>
                    </div>
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Price Impact</span>
                        <span id="priceImpact" style="color: var(--success);">-</span>
                    </div>
                    <div class="flex items-center justify-between mb-2" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Minimum Received</span>
                        <span id="minReceived" style="color: var(--text-secondary);">-</span>
                    </div>
                    <div class="flex items-center justify-between" style="font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Network Fee</span>
                        <span id="networkFee" style="color: var(--text-secondary);">~$0.50</span>
                    </div>
                </div>
            </div>

            <!-- Swap Button -->
            <button id="swapBtn" class="btn-primary w-full mt-6" onclick="executeSwap()" disabled>
                <span id="swapBtnText">Enter an amount</span>
            </button>
        </div>

        <!-- Info Card -->
        <div class="glass-card p-4 mt-4" style="border-color: rgba(99, 102, 241, 0.2);">
            <div class="flex items-center gap-4">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div>
                    <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">SertiDex</p>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Swap token dengan cepat dan aman di testnet.</p>
                </div>
            </div>
        </div>
        <!-- Recent Transactions -->
        <div class="glass-card p-4 mt-4">
            <div class="flex items-center justify-between mb-4">
                <h3 style="font-size: 1rem; font-weight: 600;">Recent Transactions</h3>
                <button onclick="clearTransactions()" style="font-size: 0.8rem; color: var(--text-muted); background: none; border: none; cursor: pointer;">Clear</button>
            </div>
            <div id="recentTransactions">
                <p style="text-align: center; color: var(--text-muted); padding: 20px; font-size: 0.9rem;">No recent transactions</p>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div class="modal-overlay" id="settingsModal" onclick="closeSettingsOutside(event)">
    <div class="modal-content glass-card p-6" style="max-width: 380px;">
        <div class="flex items-center justify-between mb-6">
            <h3 class="gradient-text" style="font-size: 1.2rem; font-weight: 700;">Settings</h3>
            <button onclick="closeSettings()" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 1.3rem;">
                ×
            </button>
        </div>

        <div class="mb-6">
            <label style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px; display: block;">Slippage Tolerance</label>
            <div class="flex gap-2">
                <button class="slippage-btn active" onclick="setSlippage(0.1)">0.1%</button>
                <button class="slippage-btn" onclick="setSlippage(0.5)">0.5%</button>
                <button class="slippage-btn" onclick="setSlippage(1.0)">1.0%</button>
                <input type="text" class="input-dark" placeholder="Custom" id="customSlippage" style="width: 70px; font-size: 0.85rem; padding: 10px; text-align: center;">
            </div>
        </div>

        <div>
            <label style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px; display: block;">Transaction Deadline</label>
            <div class="flex items-center gap-2">
                <input type="number" class="input-dark" value="20" id="txDeadline" style="width: 80px; font-size: 0.9rem; padding: 10px; text-align: center;">
                <span style="color: var(--text-muted);">minutes</span>
            </div>
        </div>
    </div>
</div>

<style>
    .slippage-btn {
        flex: 1;
        padding: 10px;
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .slippage-btn:hover, .slippage-btn.active {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary-light);
    }
</style>
@endsection

@section('scripts')
<script>
    // Swap State
    const swapState = {
        fromToken: null,
        toToken: null,
        fromAmount: '',
        toAmount: '',
        quote: null,
        slippage: 0.5,
        loading: false,
    };

    // Initialize with default tokens
    document.addEventListener('DOMContentLoaded', () => {
        const tokens = SertiDex.tokens;
        if (tokens.length > 0) {
            const nativeToken = tokens.find(t => t.is_native) || tokens[0];
            setFromToken(nativeToken);

            if (tokens.length > 1) {
                const secondToken = tokens.find(t => !t.is_native) || tokens[1];
                setToToken(secondToken);
            }
        }

        // If wallet is already connected, refresh balances
        if (SertiDex.wallet) {
            setTimeout(() => {
                refreshSwapBalances();
            }, 500);
        }

        // Listen for wallet connection changes
        window.addEventListener('walletConnected', refreshSwapBalances);
    });

    // Refresh balances for swap page
    async function refreshSwapBalances() {
        if (!SertiDex.wallet || typeof ethers === 'undefined' || !window.ethereum) return;

        try {
            const provider = new ethers.providers.Web3Provider(window.ethereum);

            // Get native balance
            const nativeBalance = await provider.getBalance(SertiDex.wallet);
            const nativeFormatted = parseFloat(ethers.utils.formatEther(nativeBalance)).toFixed(6);

            // Update native token balances
            ['ETH', 'MATIC', 'SEP', 'AMOY'].forEach(sym => {
                SertiDex.balances[sym] = nativeFormatted;
            });

            // Update UI if tokens are selected
            if (swapState.fromToken) {
                if (swapState.fromToken.is_native) {
                    document.getElementById('fromBalance').textContent = nativeFormatted;
                } else if (SertiDex.balances[swapState.fromToken.symbol]) {
                    document.getElementById('fromBalance').textContent = SertiDex.balances[swapState.fromToken.symbol];
                }
            }

            if (swapState.toToken) {
                if (swapState.toToken.is_native) {
                    document.getElementById('toBalance').textContent = nativeFormatted;
                } else if (SertiDex.balances[swapState.toToken.symbol]) {
                    document.getElementById('toBalance').textContent = SertiDex.balances[swapState.toToken.symbol];
                }
            }
        } catch (e) {
            console.error('Error refreshing swap balances:', e);
        }
    }

    function selectFromToken() {
        openTokenModal((token) => {
            if (token.address === swapState.toToken?.address) {
                swapDirection();
            } else {
                setFromToken(token);
                onAmountChange();
            }
        });
    }

    function selectToToken() {
        openTokenModal((token) => {
            if (token.address === swapState.fromToken?.address) {
                swapDirection();
            } else {
                setToToken(token);
                onAmountChange();
            }
        });
    }

    function setFromToken(token) {
        swapState.fromToken = token;
        document.getElementById('fromTokenSymbol').textContent = token.symbol;
        document.getElementById('fromTokenLogo').src = token.logo_url || '/images/tokens/default.svg';
        document.getElementById('fromBalance').textContent = SertiDex.balances[token.symbol] || '0.00';
    }

    function setToToken(token) {
        swapState.toToken = token;
        document.getElementById('toTokenSymbol').textContent = token.symbol;
        document.getElementById('toTokenLogo').src = token.logo_url || '/images/tokens/default.svg';
        document.getElementById('toBalance').textContent = SertiDex.balances[token.symbol] || '0.00';
    }

    function swapDirection() {
        const temp = swapState.fromToken;
        swapState.fromToken = swapState.toToken;
        swapState.toToken = temp;

        if (swapState.fromToken) {
            document.getElementById('fromTokenSymbol').textContent = swapState.fromToken.symbol;
            document.getElementById('fromTokenLogo').src = swapState.fromToken.logo_url || '/images/tokens/default.svg';
        }
        if (swapState.toToken) {
            document.getElementById('toTokenSymbol').textContent = swapState.toToken.symbol;
            document.getElementById('toTokenLogo').src = swapState.toToken.logo_url || '/images/tokens/default.svg';
        }

        const fromInput = document.getElementById('fromAmount');
        const toInput = document.getElementById('toAmount');
        fromInput.value = toInput.value;
        swapState.fromAmount = fromInput.value;

        onAmountChange();
    }

    function setPercentage(percent) {
        const balance = parseFloat(document.getElementById('fromBalance').textContent) || 1;
        const amount = (balance * percent / 100).toFixed(6);
        document.getElementById('fromAmount').value = amount;
        onAmountChange();
    }

    let quoteTimeout = null;
    function onAmountChange() {
        const fromAmount = document.getElementById('fromAmount').value;
        swapState.fromAmount = fromAmount;

        if (swapState.fromToken && fromAmount) {
            const usdValue = parseFloat(fromAmount) * (swapState.fromToken.price_usd || 0);
            document.getElementById('fromValueUsd').textContent = usdValue.toFixed(2);
        }

        if (quoteTimeout) clearTimeout(quoteTimeout);
        updateSwapButton();

        if (fromAmount && parseFloat(fromAmount) > 0 && swapState.fromToken && swapState.toToken) {
            quoteTimeout = setTimeout(getQuote, 500);
        } else {
            document.getElementById('toAmount').value = '';
            document.getElementById('toValueUsd').textContent = '0.00';
            document.getElementById('swapDetails').style.display = 'none';
        }
    }

    async function getQuote() {
        if (!swapState.fromToken || !swapState.toToken || !swapState.fromAmount) return;

        swapState.loading = true;
        updateSwapButton();

        try {
            const response = await fetch('{{ route("swap.quote") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    chain_id: SertiDex.currentChainId,
                    token_in: swapState.fromToken.address,
                    token_out: swapState.toToken.address,
                    amount_in: swapState.fromAmount,
                }),
            });

            const data = await response.json();

            if (data.error) {
                showToast(data.error, 'error');
                return;
            }

            swapState.quote = data;
            swapState.toAmount = data.amount_out;

            document.getElementById('toAmount').value = parseFloat(data.amount_out).toFixed(6);
            const toUsdValue = parseFloat(data.amount_out) * (swapState.toToken.price_usd || 0);
            document.getElementById('toValueUsd').textContent = toUsdValue.toFixed(2);

            document.getElementById('swapDetails').style.display = 'block';
            document.getElementById('swapRate').textContent = `1 ${swapState.fromToken.symbol} = ${data.rate} ${swapState.toToken.symbol}`;

            const impactEl = document.getElementById('priceImpact');
            impactEl.textContent = `${data.price_impact}%`;
            impactEl.style.color = data.price_impact > 3 ? 'var(--warning)' : 'var(--success)';

            document.getElementById('minReceived').textContent = `${parseFloat(data.amount_out_min).toFixed(6)} ${swapState.toToken.symbol}`;

        } catch (error) {
            console.error('Quote error:', error);
            showToast('Failed to get quote', 'error');
        } finally {
            swapState.loading = false;
            updateSwapButton();
        }
    }

    function updateSwapButton() {
        const btn = document.getElementById('swapBtn');
        const text = document.getElementById('swapBtnText');

        if (!SertiDex.wallet) {
            btn.disabled = true;
            text.textContent = 'Connect Wallet';
            btn.onclick = () => document.getElementById('walletBtn').click();
            return;
        }

        btn.onclick = executeSwap;

        if (!swapState.fromToken || !swapState.toToken) {
            btn.disabled = true;
            text.textContent = 'Select tokens';
            return;
        }

        if (!swapState.fromAmount || parseFloat(swapState.fromAmount) <= 0) {
            btn.disabled = true;
            text.textContent = 'Enter an amount';
            return;
        }

        if (swapState.loading) {
            btn.disabled = true;
            text.innerHTML = '<span class="spinner"></span> Getting quote...';
            return;
        }

        if (!swapState.quote) {
            btn.disabled = true;
            text.textContent = 'Getting quote...';
            return;
        }

        btn.disabled = false;
        text.textContent = 'Swap';
    }

    async function executeSwap() {
        if (!SertiDex.wallet || !swapState.quote) return;

        const btn = document.getElementById('swapBtn');
        const text = document.getElementById('swapBtnText');

        btn.disabled = true;

        // Router addresses per chain
        const ROUTERS = {
            11155111: '0xeE567Fe1712Faf6149d80dA1E6934E354124CfE3', // Sepolia Uniswap V2
            80002: '0xa5E0829CaCEd8fFDD4De3c43696c57F7D7A678ff'     // Amoy QuickSwap
        };

        const WETH = {
            11155111: '0x7b79995e5f793A07Bc00c21412e50Ecae098E7f9', // Sepolia WETH
            80002: '0x360ad4f9a9A8EFe9A8DCB5f461c4Cc1047E1Dcf9'     // Amoy WMATIC
        };

        const routerAddress = ROUTERS[SertiDex.currentChainId];
        const wethAddress = WETH[SertiDex.currentChainId];

        if (!routerAddress) {
            showToast('Router not available for this chain', 'error');
            updateSwapButton();
            return;
        }

        try {
            if (typeof ethers === 'undefined' || !window.ethereum) {
                showToast('Please install MetaMask to swap tokens', 'error');
                updateSwapButton();
                return;
            }

            const provider = new ethers.providers.Web3Provider(window.ethereum);
            const signer = provider.getSigner();
            const walletAddress = await signer.getAddress();

            // Router ABI for Uniswap V2
            const routerAbi = [
                'function swapExactETHForTokens(uint amountOutMin, address[] calldata path, address to, uint deadline) external payable returns (uint[] memory amounts)',
                'function swapExactTokensForETH(uint amountIn, uint amountOutMin, address[] calldata path, address to, uint deadline) external returns (uint[] memory amounts)',
                'function swapExactTokensForTokens(uint amountIn, uint amountOutMin, address[] calldata path, address to, uint deadline) external returns (uint[] memory amounts)',
                'function getAmountsOut(uint amountIn, address[] memory path) public view returns (uint[] memory amounts)'
            ];

            const router = new ethers.Contract(routerAddress, routerAbi, signer);

            // Calculate amounts
            const amountIn = ethers.utils.parseEther(swapState.fromAmount);
            const amountOutMin = ethers.utils.parseEther(
                (parseFloat(swapState.toAmount) * (1 - swapState.slippage / 100)).toFixed(18)
            );
            const deadline = Math.floor(Date.now() / 1000) + 60 * 20; // 20 minutes

            let tx;

            // Case 1: Native token (ETH/MATIC) to ERC20
            if (swapState.fromToken.is_native) {
                text.innerHTML = '<span class="spinner"></span> Confirm swap in MetaMask...';
                showToast('Please confirm the swap in MetaMask', 'success');

                const path = [wethAddress, swapState.toToken.address];

                tx = await router.swapExactETHForTokens(
                    amountOutMin,
                    path,
                    walletAddress,
                    deadline,
                    { value: amountIn }
                );
            }
            // Case 2: ERC20 to Native token (ETH/MATIC)
            else if (swapState.toToken.is_native) {
                // Step 1: Approve token
                text.innerHTML = '<span class="spinner"></span> Checking approval...';

                const erc20Abi = [
                    'function approve(address spender, uint256 amount) returns (bool)',
                    'function allowance(address owner, address spender) view returns (uint256)'
                ];
                const tokenContract = new ethers.Contract(swapState.fromToken.address, erc20Abi, signer);

                const allowance = await tokenContract.allowance(walletAddress, routerAddress);

                if (allowance.lt(amountIn)) {
                    text.innerHTML = '<span class="spinner"></span> Approve token in MetaMask...';
                    showToast('Please approve token spending', 'success');

                    const approveTx = await tokenContract.approve(routerAddress, ethers.constants.MaxUint256);
                    text.innerHTML = '<span class="spinner"></span> Waiting for approval...';
                    await approveTx.wait();
                    showToast('Token approved!', 'success');
                }

                // Step 2: Swap
                text.innerHTML = '<span class="spinner"></span> Confirm swap in MetaMask...';
                showToast('Please confirm the swap in MetaMask', 'success');

                const path = [swapState.fromToken.address, wethAddress];

                tx = await router.swapExactTokensForETH(
                    amountIn,
                    amountOutMin,
                    path,
                    walletAddress,
                    deadline
                );
            }
            // Case 3: ERC20 to ERC20
            else {
                // Step 1: Approve token
                text.innerHTML = '<span class="spinner"></span> Checking approval...';

                const erc20Abi = [
                    'function approve(address spender, uint256 amount) returns (bool)',
                    'function allowance(address owner, address spender) view returns (uint256)'
                ];
                const tokenContract = new ethers.Contract(swapState.fromToken.address, erc20Abi, signer);

                const allowance = await tokenContract.allowance(walletAddress, routerAddress);

                if (allowance.lt(amountIn)) {
                    text.innerHTML = '<span class="spinner"></span> Approve token in MetaMask...';
                    showToast('Please approve token spending', 'success');

                    const approveTx = await tokenContract.approve(routerAddress, ethers.constants.MaxUint256);
                    text.innerHTML = '<span class="spinner"></span> Waiting for approval...';
                    await approveTx.wait();
                    showToast('Token approved!', 'success');
                }

                // Step 2: Swap (through WETH)
                text.innerHTML = '<span class="spinner"></span> Confirm swap in MetaMask...';
                showToast('Please confirm the swap in MetaMask', 'success');

                const path = [swapState.fromToken.address, wethAddress, swapState.toToken.address];

                tx = await router.swapExactTokensForTokens(
                    amountIn,
                    amountOutMin,
                    path,
                    walletAddress,
                    deadline
                );
            }

            // Transaction submitted
            text.innerHTML = '<span class="spinner"></span> Swap pending...';
            showToast(`Transaction submitted! Hash: ${tx.hash.slice(0, 14)}...`, 'success');

            // Wait for confirmation
            text.innerHTML = '<span class="spinner"></span> Waiting for confirmation...';
            const receipt = await tx.wait();

            // Success!
            const explorerBase = SertiDex.currentChainId === 11155111
                ? 'https://sepolia.etherscan.io/tx/'
                : 'https://amoy.polygonscan.com/tx/';

            console.log('Swap successful:', explorerBase + receipt.transactionHash);

            // Save transaction to history
            saveTransaction({
                hash: receipt.transactionHash,
                fromSymbol: swapState.fromToken.symbol,
                toSymbol: swapState.toToken.symbol,
                fromAmount: swapState.fromAmount,
                toAmount: swapState.toAmount,
                status: 'success',
                timestamp: Date.now()
            });

            // Show success state
            text.innerHTML = '✓ Swap Successful!';
            btn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
            showToast(`Swapped ${swapState.fromAmount} ${swapState.fromToken.symbol} → ${parseFloat(swapState.toAmount).toFixed(6)} ${swapState.toToken.symbol}`, 'success');

            // Reset after 3 seconds
            setTimeout(async () => {
                btn.style.background = '';
                document.getElementById('fromAmount').value = '';
                document.getElementById('toAmount').value = '';
                document.getElementById('fromValueUsd').textContent = '0.00';
                document.getElementById('toValueUsd').textContent = '0.00';
                swapState.fromAmount = '';
                swapState.toAmount = '';
                swapState.quote = null;
                document.getElementById('swapDetails').style.display = 'none';
                updateSwapButton();

                // Refresh balances
                if (typeof loadTokenBalances === 'function') {
                    await loadTokenBalances();
                    // Update displayed balances for selected tokens
                    document.getElementById('fromBalance').textContent = SertiDex.balances[swapState.fromToken?.symbol] || '0.00';
                    document.getElementById('toBalance').textContent = SertiDex.balances[swapState.toToken?.symbol] || '0.00';
                }
            }, 3000);

        } catch (error) {
            console.error('Swap error:', error);

            // Handle specific errors
            if (error.code === 4001 || error.code === 'ACTION_REJECTED') {
                showToast('Transaction rejected by user', 'error');
            } else if (error.code === 'INSUFFICIENT_FUNDS') {
                showToast('Insufficient funds for gas', 'error');
            } else if (error.message?.includes('INSUFFICIENT_OUTPUT_AMOUNT')) {
                showToast('Slippage too low - increase slippage tolerance', 'error');
            } else if (error.message?.includes('EXPIRED')) {
                showToast('Transaction expired - try again', 'error');
            } else if (error.message?.includes('TRANSFER_FAILED')) {
                showToast('Token transfer failed', 'error');
            } else {
                showToast('Swap failed: ' + (error.reason || error.message?.slice(0, 50) || 'Unknown error'), 'error');
            }

            updateSwapButton();
        }
    }

    // Settings
    function openSettings() {
        document.getElementById('settingsModal').classList.add('active');
    }

    function closeSettings() {
        document.getElementById('settingsModal').classList.remove('active');
    }

    function closeSettingsOutside(e) {
        if (e.target === document.getElementById('settingsModal')) {
            closeSettings();
        }
    }

    function setSlippage(value) {
        swapState.slippage = value;
        localStorage.setItem('sertidex_slippage', value);
        document.querySelectorAll('.slippage-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    }

    // Recent Transactions
    function getTransactions() {
        const stored = localStorage.getItem('sertidex_transactions');
        return stored ? JSON.parse(stored) : [];
    }

    function saveTransaction(tx) {
        const transactions = getTransactions();
        transactions.unshift(tx);
        if (transactions.length > 10) transactions.pop();
        localStorage.setItem('sertidex_transactions', JSON.stringify(transactions));
        renderTransactions();
    }

    function clearTransactions() {
        localStorage.removeItem('sertidex_transactions');
        renderTransactions();
    }

    function renderTransactions() {
        const container = document.getElementById('recentTransactions');
        const transactions = getTransactions();

        if (transactions.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: var(--text-muted); padding: 20px; font-size: 0.9rem;">No recent transactions</p>';
            return;
        }

        container.innerHTML = transactions.map(tx => {
            const statusClass = tx.status === 'pending' ? 'pending' : tx.status === 'success' ? 'success' : 'failed';
            const statusIcon = tx.status === 'pending' ? '⏳' : tx.status === 'success' ? '✓' : '✗';
            const explorerUrl = SertiDex.currentChainId === 11155111
                ? `https://sepolia.etherscan.io/tx/${tx.hash}`
                : `https://amoy.polygonscan.com/tx/${tx.hash}`;

            return `
                <div class="tx-item">
                    <div class="flex items-center gap-2">
                        <div class="tx-status ${statusClass}"></div>
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">Swap ${tx.fromSymbol} → ${tx.toSymbol}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">${tx.fromAmount} ${tx.fromSymbol}</div>
                        </div>
                    </div>
                    <a href="${explorerUrl}" target="_blank" style="color: var(--primary-light); font-size: 0.8rem; text-decoration: none;">
                        View ↗
                    </a>
                </div>
            `;
        }).join('');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        // Load saved slippage
        const savedSlippage = localStorage.getItem('sertidex_slippage');
        if (savedSlippage) {
            swapState.slippage = parseFloat(savedSlippage);
        }

        // Render transactions
        renderTransactions();
    });
</script>
@endsection
