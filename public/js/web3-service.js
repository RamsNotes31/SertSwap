// SertiDex Web3 Service
// Real-time blockchain interactions using ethers.js

const Web3Service = {
    provider: null,
    signer: null,
    
    // ERC20 ABI for balance and approval
    ERC20_ABI: [
        "function balanceOf(address owner) view returns (uint256)",
        "function decimals() view returns (uint8)",
        "function symbol() view returns (string)",
        "function approve(address spender, uint256 amount) returns (bool)",
        "function allowance(address owner, address spender) view returns (uint256)"
    ],
    
    // Uniswap V2 Router ABI
    ROUTER_ABI: [
        "function getAmountsOut(uint amountIn, address[] memory path) view returns (uint[] memory amounts)",
        "function swapExactETHForTokens(uint amountOutMin, address[] calldata path, address to, uint deadline) payable returns (uint[] memory amounts)",
        "function swapExactTokensForETH(uint amountIn, uint amountOutMin, address[] calldata path, address to, uint deadline) returns (uint[] memory amounts)",
        "function swapExactTokensForTokens(uint amountIn, uint amountOutMin, address[] calldata path, address to, uint deadline) returns (uint[] memory amounts)"
    ],

    // Router addresses per chain
    ROUTERS: {
        11155111: '0xC532a74256D3Db42D0Bf7a0400fEFDbad7694008', // Sepolia Uniswap
        80002: '0x1b02dA8Cb0d097eB8D57A175b88c7D8b47997506' // Amoy SushiSwap
    },

    // WETH addresses per chain
    WETH: {
        11155111: '0x7b79995e5f793A07Bc00c21412e50Ecae098E7f9', // Sepolia WETH
        80002: '0x0d500B1d8E8eF31E21C99d1Db9A6444d3ADf1270' // Amoy WMATIC
    },

    async init() {
        if (typeof window.ethereum !== 'undefined') {
            this.provider = new ethers.BrowserProvider(window.ethereum);
            return true;
        }
        return false;
    },

    async getSigner() {
        if (!this.provider) await this.init();
        this.signer = await this.provider.getSigner();
        return this.signer;
    },

    // Get native token balance (ETH/MATIC)
    async getNativeBalance(address) {
        if (!this.provider) await this.init();
        try {
            const balance = await this.provider.getBalance(address);
            return ethers.formatEther(balance);
        } catch (error) {
            console.error('Error getting native balance:', error);
            return '0';
        }
    },

    // Get ERC20 token balance
    async getTokenBalance(tokenAddress, walletAddress) {
        if (!this.provider) await this.init();
        
        // Handle native token
        if (tokenAddress === '0x0000000000000000000000000000000000000000' || 
            tokenAddress.toLowerCase() === 'native') {
            return await this.getNativeBalance(walletAddress);
        }

        try {
            const contract = new ethers.Contract(tokenAddress, this.ERC20_ABI, this.provider);
            const [balance, decimals] = await Promise.all([
                contract.balanceOf(walletAddress),
                contract.decimals()
            ]);
            return ethers.formatUnits(balance, decimals);
        } catch (error) {
            console.error('Error getting token balance:', error);
            return '0';
        }
    },

    // Get all token balances
    async getAllBalances(tokens, walletAddress) {
        const balances = {};
        
        for (const token of tokens) {
            try {
                const balance = await this.getTokenBalance(token.address, walletAddress);
                balances[token.symbol] = parseFloat(balance).toFixed(6);
            } catch (error) {
                balances[token.symbol] = '0';
            }
        }
        
        return balances;
    },

    // Get swap quote from router
    async getSwapQuote(chainId, tokenIn, tokenOut, amountIn) {
        if (!this.provider) await this.init();
        
        const routerAddress = this.ROUTERS[chainId];
        if (!routerAddress) {
            throw new Error('Router not available for this chain');
        }

        try {
            const router = new ethers.Contract(routerAddress, this.ROUTER_ABI, this.provider);
            
            // Build path
            let path;
            const weth = this.WETH[chainId];
            
            if (tokenIn === 'native' || tokenIn === '0x0000000000000000000000000000000000000000') {
                path = [weth, tokenOut];
            } else if (tokenOut === 'native' || tokenOut === '0x0000000000000000000000000000000000000000') {
                path = [tokenIn, weth];
            } else {
                // Token to Token - go through WETH
                path = [tokenIn, weth, tokenOut];
            }

            const amountInWei = ethers.parseEther(amountIn.toString());
            const amounts = await router.getAmountsOut(amountInWei, path);
            const amountOut = ethers.formatEther(amounts[amounts.length - 1]);
            
            return {
                amountOut,
                path,
                priceImpact: Math.random() * 0.5 // Simulated for now
            };
        } catch (error) {
            console.error('Error getting quote:', error);
            throw error;
        }
    },

    // Check and approve token spending
    async approveToken(tokenAddress, spenderAddress, amount) {
        const signer = await this.getSigner();
        const contract = new ethers.Contract(tokenAddress, this.ERC20_ABI, signer);
        
        const walletAddress = await signer.getAddress();
        const currentAllowance = await contract.allowance(walletAddress, spenderAddress);
        const amountWei = ethers.parseEther(amount.toString());
        
        if (currentAllowance < amountWei) {
            const tx = await contract.approve(spenderAddress, ethers.MaxUint256);
            await tx.wait();
            return tx.hash;
        }
        
        return null; // Already approved
    },

    // Execute swap
    async executeSwap(chainId, tokenIn, tokenOut, amountIn, amountOutMin, deadline = 20) {
        const signer = await this.getSigner();
        const walletAddress = await signer.getAddress();
        
        const routerAddress = this.ROUTERS[chainId];
        const router = new ethers.Contract(routerAddress, this.ROUTER_ABI, signer);
        const weth = this.WETH[chainId];
        
        const deadlineTimestamp = Math.floor(Date.now() / 1000) + (deadline * 60);
        const amountInWei = ethers.parseEther(amountIn.toString());
        const amountOutMinWei = ethers.parseEther(amountOutMin.toString());
        
        let tx;
        
        // Native to Token
        if (tokenIn === 'native' || tokenIn === '0x0000000000000000000000000000000000000000') {
            const path = [weth, tokenOut];
            tx = await router.swapExactETHForTokens(
                amountOutMinWei,
                path,
                walletAddress,
                deadlineTimestamp,
                { value: amountInWei }
            );
        }
        // Token to Native
        else if (tokenOut === 'native' || tokenOut === '0x0000000000000000000000000000000000000000') {
            const path = [tokenIn, weth];
            
            // Approve first
            await this.approveToken(tokenIn, routerAddress, amountIn);
            
            tx = await router.swapExactTokensForETH(
                amountInWei,
                amountOutMinWei,
                path,
                walletAddress,
                deadlineTimestamp
            );
        }
        // Token to Token
        else {
            const path = [tokenIn, weth, tokenOut];
            
            // Approve first
            await this.approveToken(tokenIn, routerAddress, amountIn);
            
            tx = await router.swapExactTokensForTokens(
                amountInWei,
                amountOutMinWei,
                path,
                walletAddress,
                deadlineTimestamp
            );
        }
        
        return tx;
    },

    // Get transaction receipt
    async waitForTransaction(txHash) {
        if (!this.provider) await this.init();
        const receipt = await this.provider.waitForTransaction(txHash);
        return receipt;
    },

    // Get explorer URL
    getExplorerUrl(chainId, txHash) {
        const explorers = {
            11155111: 'https://sepolia.etherscan.io/tx/',
            80002: 'https://amoy.polygonscan.com/tx/'
        };
        return (explorers[chainId] || '') + txHash;
    }
};

// Make it globally available
window.Web3Service = Web3Service;
