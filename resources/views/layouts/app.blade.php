<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SertiDex') - Decentralized Exchange</title>
    <meta name="description" content="SertiDex - Platform DEX multi-chain untuk swap token di testnet Sepolia dan Amoy">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Ethers.js -->
    <script src="https://cdn.ethers.io/lib/ethers-5.7.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6366F1;
            --primary-light: #818CF8;
            --primary-dark: #4F46E5;
            --secondary: #8B5CF6;
            --accent: #A78BFA;
            --bg-dark: #0F0F1A;
            --bg-card: #1A1A2E;
            --bg-card-hover: #252542;
            --bg-input: #16162A;
            --border-color: rgba(99, 102, 241, 0.3);
            --text-primary: #F8FAFC;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .bg-gradient {
            position: fixed;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(ellipse at top left, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                var(--bg-dark);
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .glass-card {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(99, 102, 241, 0.5);
        }

        .gradient-text {
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .input-dark {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            color: var(--text-primary);
            font-size: 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input-dark:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .token-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: var(--bg-card-hover);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .token-selector:hover {
            border-color: var(--primary);
        }

        .token-selector img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .swap-arrow {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: 3px solid var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: -8px auto;
            position: relative;
            z-index: 10;
        }

        .swap-arrow:hover {
            transform: rotate(180deg);
        }

        .swap-arrow svg {
            width: 20px;
            height: 20px;
            stroke: white;
        }

        .nav-link {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 10px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(99, 102, 241, 0.1);
        }

        .nav-link.active {
            color: var(--text-primary);
            background: rgba(99, 102, 241, 0.2);
        }

        .chain-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chain-selector:hover {
            border-color: var(--primary);
        }

        .chain-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--success);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Wallet Connection */
        .wallet-container { position: relative; }

        .wallet-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }

        .wallet-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .wallet-btn.connected {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
        }

        .wallet-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 320px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            display: none;
            z-index: 1000;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .wallet-dropdown.active { display: block; animation: fadeIn 0.2s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .wallet-address {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: var(--bg-input);
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .copy-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
        }

        .token-balance-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .token-balance-item:last-child { border-bottom: none; }

        .token-balance-item .token-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .token-balance-item img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }

        .disconnect-btn {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            color: var(--error);
            font-weight: 600;
            cursor: pointer;
        }

        .disconnect-btn:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* Wallet Selection Modal */
        .wallet-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .wallet-modal.active { display: flex; }

        .wallet-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 12px;
        }

        .wallet-option:hover {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.1);
        }

        .wallet-option:last-child { margin-bottom: 0; }

        .wallet-option img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }

        .wallet-option .wallet-name {
            font-weight: 600;
            font-size: 1rem;
        }

        .wallet-option .wallet-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal-content {
            max-width: 420px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            animation: modalPop 0.3s ease;
        }

        @keyframes modalPop {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .token-list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .token-list-item:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        .token-list-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            z-index: 10000;
            transform: translateX(400px);
            transition: transform 0.4s ease;
            font-weight: 600;
            max-width: 360px;
        }

        .toast.show { transform: translateX(0); }
        .toast-success { background: rgba(16, 185, 129, 0.2); border: 1px solid var(--success); color: var(--success); }
        .toast-error { background: rgba(239, 68, 68, 0.2); border: 1px solid var(--error); color: var(--error); }
        .toast-info { background: rgba(99, 102, 241, 0.2); border: 1px solid var(--primary); color: var(--primary-light); }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(99, 102, 241, 0.3);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .quick-btn {
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 700;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--primary-light);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-btn:hover { background: rgba(99, 102, 241, 0.2); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 4px; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .flex-col { flex-direction: column; }
        .gap-2 { gap: 8px; }
        .gap-4 { gap: 16px; }
        .p-4 { padding: 16px; }
        .p-6 { padding: 24px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-6 { margin-bottom: 24px; }
        .mt-4 { margin-top: 16px; }
        .mt-6 { margin-top: 24px; }
        .text-sm { font-size: 0.875rem; }
        .w-full { width: 100%; }
        .hidden { display: none; }

        /* Recent Transactions */
        .tx-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: var(--bg-input);
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .tx-item:last-child { margin-bottom: 0; }

        .tx-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .tx-status.pending { background: var(--warning); animation: pulse 1s infinite; }
        .tx-status.success { background: var(--success); }
        .tx-status.failed { background: var(--error); }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            nav { display: none; }
            .wallet-dropdown { width: 280px; right: -20px; }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    <div class="bg-grid"></div>

    <!-- Header -->
    <header class="container" style="padding-top: 16px; padding-bottom: 16px;">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center gap-2" style="text-decoration: none;">
                <img src="/images/logo.svg" alt="SertiDex" style="width: 40px; height: 40px;">
                <span class="gradient-text" style="font-size: 1.5rem; font-weight: 800;">SertiDex</span>
            </a>

            <nav class="flex items-center gap-2">
                <a href="{{ route('swap') }}" class="nav-link {{ request()->routeIs('swap') ? 'active' : '' }}">Swap</a>
                <a href="{{ route('liquidity') }}" class="nav-link {{ request()->routeIs('liquidity*') ? 'active' : '' }}">Liquidity</a>
            </nav>

            <div class="flex items-center gap-4">
                <div class="chain-selector" id="chainSelector" onclick="openChainModal()">
                    <div class="chain-dot" id="chainDot"></div>
                    <span id="chainName" style="font-size: 0.9rem; font-weight: 600;">Sepolia</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </div>

                <div class="wallet-container">
                    <button class="wallet-btn" id="walletBtn" onclick="handleWalletClick()">
                        <span id="walletBtnText">Connect Wallet</span>
                    </button>

                    <div class="wallet-dropdown" id="walletDropdown">
                        <div style="margin-bottom: 12px;">
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Connected via <span id="walletProvider">-</span></span>
                        </div>

                        <div class="wallet-address">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 50%;"></div>
                            <span id="fullAddress" style="font-family: monospace; font-size: 0.9rem;">0x0000...0000</span>
                            <button class="copy-btn" onclick="copyAddress()" title="Copy">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>

                        <div style="margin-bottom: 8px;">
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Balances</span>
                        </div>

                        <div id="tokenBalances">
                            <div style="text-align: center; padding: 20px;">
                                <span class="spinner"></span>
                            </div>
                        </div>

                        <button class="disconnect-btn" onclick="disconnectWallet()">
                            Disconnect
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container" style="padding-top: 40px; padding-bottom: 60px;">
        @yield('content')
    </main>

    <footer class="container" style="text-align: center; padding-bottom: 40px;">
        <p style="font-size: 0.85rem; color: var(--text-muted);">
            SertiDex © 2026 • <a href="#" style="color: var(--primary-light); text-decoration: none;">Docs</a> •
            <a href="#" style="color: var(--primary-light); text-decoration: none;">GitHub</a>
        </p>
    </footer>

    <!-- Wallet Selection Modal -->
    <div class="wallet-modal" id="walletModal" onclick="closeWalletModalOutside(event)">
        <div class="modal-content glass-card p-6" style="max-width: 380px;">
            <div class="flex items-center justify-between mb-6">
                <h3 class="gradient-text" style="font-size: 1.3rem; font-weight: 700;">Connect Wallet</h3>
                <button onclick="closeWalletModal()" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 1.5rem;">×</button>
            </div>

            <div class="wallet-option" onclick="connectWithProvider('metamask')">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 507.83 470.86'%3E%3Cdefs%3E%3Cstyle%3E.a%7Bfill:%23e17726;%7D.b%7Bfill:%23d5bfb2;%7D.c%7Bfill:%23233447;%7D.d%7Bfill:%23cc6228;%7D.e%7Bfill:%23e27525;%7D.f%7Bfill:%23f5841f;%7D.g%7Bfill:%23c0ac9d;%7D.h%7Bfill:%23161616;%7D.i%7Bfill:%23763e1a;%7D%3C/style%3E%3C/defs%3E%3Cpath class='a' d='M482.09,0.5L284.32,147.38l36.58-86.66Z'/%3E%3C/svg%3E" alt="MetaMask">
                <div>
                    <div class="wallet-name">MetaMask</div>
                    <div class="wallet-desc">Connect using browser extension</div>
                </div>
            </div>

            <div class="wallet-option" onclick="connectWithProvider('walletconnect')">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 400'%3E%3Ccircle cx='200' cy='200' r='200' fill='%233B99FC'/%3E%3Cpath d='M122.5 161.5c42.5-42.5 111.5-42.5 154 0l5.1 5.1c2.1 2.1 2.1 5.5 0 7.6l-17.5 17.5c-1.1 1.1-2.7 1.1-3.8 0l-7-7c-29.6-29.6-77.7-29.6-107.3 0l-7.5 7.5c-1.1 1.1-2.7 1.1-3.8 0l-17.5-17.5c-2.1-2.1-2.1-5.5 0-7.6l5.3-5.6zm190.3 35.5l15.6 15.6c2.1 2.1 2.1 5.5 0 7.6l-70.2 70.2c-2.1 2.1-5.5 2.1-7.6 0l-49.8-49.8c-.5-.5-1.4-.5-1.9 0l-49.8 49.8c-2.1 2.1-5.5 2.1-7.6 0l-70.2-70.2c-2.1-2.1-2.1-5.5 0-7.6l15.6-15.6c2.1-2.1 5.5-2.1 7.6 0l49.8 49.8c.5.5 1.4.5 1.9 0l49.8-49.8c2.1-2.1 5.5-2.1 7.6 0l49.8 49.8c.5.5 1.4.5 1.9 0l49.8-49.8c2.2-2.1 5.6-2.1 7.7 0z' fill='%23fff'/%3E%3C/svg%3E" alt="WalletConnect">
                <div>
                    <div class="wallet-name">WalletConnect</div>
                    <div class="wallet-desc">Scan with mobile wallet</div>
                </div>
            </div>

            <div class="wallet-option" onclick="connectWithProvider('coinbase')">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1024 1024'%3E%3Ccircle cx='512' cy='512' r='512' fill='%230052FF'/%3E%3Cpath d='M512 256c-141.4 0-256 114.6-256 256s114.6 256 256 256 256-114.6 256-256-114.6-256-256-256zm-76 332c0 8.8-7.2 16-16 16h-24c-8.8 0-16-7.2-16-16v-24c0-8.8 7.2-16 16-16h24c8.8 0 16 7.2 16 16v24zm0-80c0 8.8-7.2 16-16 16h-24c-8.8 0-16-7.2-16-16v-24c0-8.8 7.2-16 16-16h24c8.8 0 16 7.2 16 16v24zm152 80c0 8.8-7.2 16-16 16h-24c-8.8 0-16-7.2-16-16v-24c0-8.8 7.2-16 16-16h24c8.8 0 16 7.2 16 16v24zm0-80c0 8.8-7.2 16-16 16h-24c-8.8 0-16-7.2-16-16v-24c0-8.8 7.2-16 16-16h24c8.8 0 16 7.2 16 16v24z' fill='%23fff'/%3E%3C/svg%3E" alt="Coinbase">
                <div>
                    <div class="wallet-name">Coinbase Wallet</div>
                    <div class="wallet-desc">Connect using Coinbase</div>
                </div>
            </div>

            <div class="wallet-option" onclick="connectWithProvider('trustwallet')">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1024 1024'%3E%3Ccircle cx='512' cy='512' r='512' fill='%233375BB'/%3E%3Cpath d='M512 192c-176.7 0-320 143.3-320 320s143.3 320 320 320 320-143.3 320-320-143.3-320-320-320zm0 576c-141.4 0-256-114.6-256-256s114.6-256 256-256 256 114.6 256 256-114.6 256-256 256z' fill='%23fff'/%3E%3Cpath d='M512 320c-28.7 0-52.3 0-76.8 25.6-24.5 25.6-51.2 89.6-51.2 153.6s25.6 115.2 51.2 140.8c25.6 25.6 51.2 51.2 76.8 51.2s51.2-25.6 76.8-51.2c25.6-25.6 51.2-76.8 51.2-140.8s-25.6-128-51.2-153.6c-25.6-25.6-48.1-25.6-76.8-25.6z' fill='%23fff'/%3E%3C/svg%3E" alt="Trust Wallet">
                <div>
                    <div class="wallet-name">Trust Wallet</div>
                    <div class="wallet-desc">Connect using Trust Wallet</div>
                </div>
            </div>

            <div class="wallet-option" onclick="connectWithProvider('injected')">
                <div style="width: 40px; height: 40px; background: var(--bg-card-hover); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div>
                    <div class="wallet-name">Browser Wallet</div>
                    <div class="wallet-desc">Use any injected provider</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chain Modal -->
    <div class="modal-overlay" id="chainModal" onclick="closeChainModalOutside(event)">
        <div class="modal-content glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="gradient-text" style="font-size: 1.3rem;">Select Network</h3>
                <button onclick="closeChainModal()" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 1.5rem;">×</button>
            </div>
            <div id="chainList"></div>
        </div>
    </div>

    <!-- Token Modal -->
    <div class="modal-overlay" id="tokenModal" onclick="closeTokenModalOutside(event)">
        <div class="modal-content glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="gradient-text" style="font-size: 1.3rem;">Select Token</h3>
                <button onclick="closeTokenModal()" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); font-size: 1.5rem;">×</button>
            </div>
            <input type="text" class="input-dark mb-4" placeholder="Search by name or address" id="tokenSearch" onkeyup="filterTokens()" style="font-size: 1rem; padding: 12px 16px;">
            <div id="tokenList" style="max-height: 400px; overflow-y: auto;"></div>
        </div>
    </div>

    <div id="toastContainer"></div>

    <script>
        // Global State
        window.SertiDex = {
            chains: @json($chains ?? []),
            tokens: @json($tokens ?? []),
            currentChainId: {{ $currentChainId ?? config('chains.sepolia.chain_id') }},
            wallet: null,
            balances: {},
            provider: null,
            signer: null,
            walletType: null,
        };

        const chainConfig = {
            11155111: { color: '#627EEA', name: 'Sepolia', symbol: 'ETH' },
            80002: { color: '#8247E5', name: 'Amoy', symbol: 'MATIC' },
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            const cfg = chainConfig[SertiDex.currentChainId];
            if (cfg) {
                document.getElementById('chainDot').style.background = cfg.color;
                document.getElementById('chainName').textContent = cfg.name;
            }

            // Auto-connect if previously connected
            const savedWallet = localStorage.getItem('sertidex_wallet');
            const savedType = localStorage.getItem('sertidex_wallet_type');
            if (savedWallet && savedType && window.ethereum) {
                window.ethereum.request({ method: 'eth_accounts' }).then(accounts => {
                    if (accounts.length > 0 && accounts[0].toLowerCase() === savedWallet.toLowerCase()) {
                        SertiDex.wallet = accounts[0];
                        SertiDex.walletType = savedType;
                        updateWalletUI();
                        loadTokenBalances();
                    }
                });
            }
        });

        // Wallet Functions
        function handleWalletClick() {
            if (SertiDex.wallet) {
                document.getElementById('walletDropdown').classList.toggle('active');
            } else {
                openWalletModal();
            }
        }

        function openWalletModal() {
            document.getElementById('walletModal').classList.add('active');
        }

        function closeWalletModal() {
            document.getElementById('walletModal').classList.remove('active');
        }

        function closeWalletModalOutside(e) {
            if (e.target.id === 'walletModal') closeWalletModal();
        }

        // Helper function to detect and get the correct provider
        function getInjectedProvider(type) {
            // Check for multiple providers (when user has multiple wallets)
            if (window.ethereum?.providers?.length) {
                for (const p of window.ethereum.providers) {
                    if (type === 'metamask' && p.isMetaMask && !p.isBraveWallet) return p;
                    if (type === 'coinbase' && p.isCoinbaseWallet) return p;
                    if (type === 'brave' && p.isBraveWallet) return p;
                }
            }

            // Single provider checks
            if (window.ethereum) {
                // Brave wallet detection
                if (type === 'brave' && window.ethereum.isBraveWallet) return window.ethereum;
                // MetaMask detection (ensure not Brave pretending to be MetaMask)
                if (type === 'metamask' && window.ethereum.isMetaMask && !window.ethereum.isBraveWallet) return window.ethereum;
                // Coinbase detection
                if (type === 'coinbase' && (window.ethereum.isCoinbaseWallet || window.coinbaseWalletExtension)) {
                    return window.coinbaseWalletExtension || window.ethereum;
                }
                // Trust Wallet detection
                if (type === 'trustwallet' && (window.trustwallet || window.ethereum.isTrust)) {
                    return window.trustwallet || window.ethereum;
                }
                // Opera detection
                if (type === 'opera' && window.ethereum.isOpera) return window.ethereum;
                // Generic injected provider
                if (type === 'injected') return window.ethereum;
            }

            return null;
        }

        // Detect which wallet is available
        function getDetectedWalletName() {
            if (window.ethereum?.isBraveWallet) return 'Brave Wallet';
            if (window.ethereum?.isMetaMask) return 'MetaMask';
            if (window.ethereum?.isCoinbaseWallet) return 'Coinbase';
            if (window.ethereum?.isTrust || window.trustwallet) return 'Trust Wallet';
            if (window.ethereum?.isOpera) return 'Opera Wallet';
            if (window.ethereum) return 'Browser Wallet';
            return null;
        }

        async function connectWithProvider(providerType) {
            closeWalletModal();

            let provider = null;
            let providerName = providerType;

            try {
                // Handle injected/browser wallet - auto-detect the wallet type
                if (providerType === 'injected') {
                    provider = window.ethereum;
                    providerName = getDetectedWalletName() || 'Browser Wallet';

                    if (!provider) {
                        showToast('No Web3 wallet detected. Please install MetaMask or Brave Wallet.', 'error');
                        return;
                    }
                } else {
                    // Specific wallet requested
                    switch (providerType) {
                        case 'metamask':
                            provider = getInjectedProvider('metamask');
                            if (!provider) {
                                // Check if any ethereum provider exists (might be Brave pretending to be MetaMask)
                                if (window.ethereum?.isMetaMask) {
                                    provider = window.ethereum;
                                    providerName = getDetectedWalletName() || 'MetaMask';
                                } else {
                                    window.open('https://metamask.io/download/', '_blank');
                                    showToast('Please install MetaMask', 'info');
                                    return;
                                }
                            }
                            break;

                        case 'coinbase':
                            provider = getInjectedProvider('coinbase');
                            if (!provider) {
                                window.open('https://www.coinbase.com/wallet', '_blank');
                                showToast('Please install Coinbase Wallet', 'info');
                                return;
                            }
                            break;

                        case 'trustwallet':
                            provider = getInjectedProvider('trustwallet');
                            if (!provider) {
                                window.open('https://trustwallet.com/', '_blank');
                                showToast('Please install Trust Wallet', 'info');
                                return;
                            }
                            break;

                        case 'walletconnect':
                            showToast('WalletConnect coming soon. Use Browser Wallet for now.', 'info');
                            return;

                        default:
                            provider = window.ethereum;
                            providerName = getDetectedWalletName() || 'Browser Wallet';
                            break;
                    }
                }

                if (!provider) {
                    showToast('Wallet not detected. Please install a Web3 wallet.', 'error');
                    return;
                }

                showToast('Connecting to ' + providerName + '...', 'info');

                const accounts = await provider.request({ method: 'eth_requestAccounts' });

                if (accounts.length === 0) {
                    showToast('No accounts found', 'error');
                    return;
                }

                SertiDex.wallet = accounts[0];
                SertiDex.walletType = providerType;
                SertiDex.provider = new ethers.providers.Web3Provider(provider);
                SertiDex.signer = SertiDex.provider.getSigner();

                // Save to localStorage
                localStorage.setItem('sertidex_wallet', accounts[0]);
                localStorage.setItem('sertidex_wallet_type', providerType);

                updateWalletUI();
                await loadTokenBalances();
                showToast('Wallet connected!', 'success');

                // Dispatch wallet connected event for other components
                window.dispatchEvent(new CustomEvent('walletConnected', { detail: { address: accounts[0] } }));

                // Setup listeners
                provider.on('accountsChanged', handleAccountsChanged);
                provider.on('chainChanged', handleChainChanged);

            } catch (error) {
                console.error('Connection error:', error);
                if (error.code === 4001) {
                    showToast('Connection rejected', 'error');
                } else {
                    showToast('Failed to connect: ' + (error.message || 'Unknown error'), 'error');
                }
            }
        }

        function handleAccountsChanged(accounts) {
            if (accounts.length === 0) {
                disconnectWallet();
            } else {
                SertiDex.wallet = accounts[0];
                localStorage.setItem('sertidex_wallet', accounts[0]);
                updateWalletUI();
                loadTokenBalances();

                // Dispatch event for other components
                window.dispatchEvent(new CustomEvent('walletConnected', { detail: { address: accounts[0] } }));
            }
        }

        function handleChainChanged(chainIdHex) {
            const chainId = parseInt(chainIdHex, 16);
            if (chainConfig[chainId]) {
                window.location.href = `${window.location.pathname}?chain=${chainId}`;
            }
        }

        function disconnectWallet() {
            SertiDex.wallet = null;
            SertiDex.walletType = null;
            SertiDex.balances = {};
            SertiDex.provider = null;
            SertiDex.signer = null;

            localStorage.removeItem('sertidex_wallet');
            localStorage.removeItem('sertidex_wallet_type');

            document.getElementById('walletDropdown').classList.remove('active');
            updateWalletUI();
            showToast('Wallet disconnected', 'success');
        }

        function updateWalletUI() {
            const btn = document.getElementById('walletBtn');
            const text = document.getElementById('walletBtnText');

            if (SertiDex.wallet) {
                btn.classList.add('connected');
                text.textContent = SertiDex.wallet.slice(0, 6) + '...' + SertiDex.wallet.slice(-4);
                document.getElementById('fullAddress').textContent = SertiDex.wallet.slice(0, 10) + '...' + SertiDex.wallet.slice(-8);

                // Use detected wallet name for display
                const walletName = getDetectedWalletName() || SertiDex.walletType || 'Unknown';
                document.getElementById('walletProvider').textContent = walletName;
            } else {
                btn.classList.remove('connected');
                text.textContent = 'Connect Wallet';
            }
        }

        async function loadTokenBalances() {
            if (!SertiDex.wallet) return;

            const container = document.getElementById('tokenBalances');
            container.innerHTML = '<div style="text-align: center; padding: 20px;"><span class="spinner"></span></div>';

            // Load all tokens, not just first 5
            const tokens = SertiDex.tokens;

            try {
                if (typeof ethers !== 'undefined' && window.ethereum && SertiDex.wallet) {
                    const provider = new ethers.providers.Web3Provider(window.ethereum);

                    // First get native balance
                    try {
                        const nativeBalance = await provider.getBalance(SertiDex.wallet);
                        const nativeBalanceFormatted = parseFloat(ethers.utils.formatEther(nativeBalance)).toFixed(6);

                        // Set for all native token symbols
                        const nativeSymbols = ['ETH', 'MATIC', 'SEP', 'AMOY'];
                        nativeSymbols.forEach(sym => {
                            SertiDex.balances[sym] = nativeBalanceFormatted;
                        });
                    } catch (e) {
                        console.error('Error getting native balance:', e);
                    }

                    // Then get ERC20 balances
                    for (const token of tokens) {
                        try {
                            if (token.is_native) {
                                // Already set native balance above
                                const nativeBalance = await provider.getBalance(SertiDex.wallet);
                                SertiDex.balances[token.symbol] = parseFloat(ethers.utils.formatEther(nativeBalance)).toFixed(6);
                            } else if (token.address &&
                                       token.address !== '0x0000000000000000000000000000000000000000' &&
                                       token.address.startsWith('0x')) {
                                const abi = [
                                    'function balanceOf(address) view returns (uint256)',
                                    'function decimals() view returns (uint8)'
                                ];
                                const contract = new ethers.Contract(token.address, abi, provider);

                                const [balance, decimals] = await Promise.all([
                                    contract.balanceOf(SertiDex.wallet),
                                    contract.decimals()
                                ]);

                                SertiDex.balances[token.symbol] = parseFloat(ethers.utils.formatUnits(balance, decimals)).toFixed(6);
                            } else {
                                SertiDex.balances[token.symbol] = '0.000000';
                            }
                        } catch (e) {
                            console.error(`Error getting balance for ${token.symbol}:`, e);
                            SertiDex.balances[token.symbol] = '0.000000';
                        }
                    }
                } else {
                    tokens.forEach(t => { SertiDex.balances[t.symbol] = '0.000000'; });
                }
            } catch (e) {
                console.error('Error loading balances:', e);
                tokens.forEach(t => { SertiDex.balances[t.symbol] = '0.000000'; });
            }

            // Render dropdown balances (show first 5)
            renderTokenBalances(tokens.slice(0, 5));

            // Update swap page balances if we're on swap page
            updateSwapPageBalances();
        }

        // Function to update swap page balance displays
        function updateSwapPageBalances() {
            // Update "From" token balance
            const fromBalanceEl = document.getElementById('fromBalance');
            const toBalanceEl = document.getElementById('toBalance');
            const fromTokenSymbol = document.getElementById('fromTokenSymbol');
            const toTokenSymbol = document.getElementById('toTokenSymbol');

            if (fromBalanceEl && fromTokenSymbol) {
                const fromSymbol = fromTokenSymbol.textContent;
                if (fromSymbol && SertiDex.balances[fromSymbol]) {
                    fromBalanceEl.textContent = SertiDex.balances[fromSymbol];
                }
            }

            if (toBalanceEl && toTokenSymbol) {
                const toSymbol = toTokenSymbol.textContent;
                if (toSymbol && toSymbol !== 'Select' && SertiDex.balances[toSymbol]) {
                    toBalanceEl.textContent = SertiDex.balances[toSymbol];
                }
            }
        }

        function renderTokenBalances(tokens) {
            const container = document.getElementById('tokenBalances');
            let html = '';

            tokens.forEach(token => {
                const balance = SertiDex.balances[token.symbol] || '0.000000';
                const value = (parseFloat(balance) * (token.price_usd || 1)).toFixed(2);

                html += `
                    <div class="token-balance-item">
                        <div class="token-info">
                            <img src="${token.logo_url || '/images/tokens/default.svg'}" alt="${token.symbol}" onerror="this.src='/images/tokens/default.svg'">
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem;">${token.symbol}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">${token.name}</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600; font-size: 0.9rem;">${balance}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">$${value}</div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html || '<p style="text-align: center; color: var(--text-muted);">No tokens</p>';
        }

        function copyAddress() {
            if (SertiDex.wallet) {
                navigator.clipboard.writeText(SertiDex.wallet);
                showToast('Address copied!', 'success');
            }
        }

        document.addEventListener('click', (e) => {
            const container = document.querySelector('.wallet-container');
            if (container && !container.contains(e.target)) {
                document.getElementById('walletDropdown').classList.remove('active');
            }
        });

        // Chain Modal
        function openChainModal() {
            const list = document.getElementById('chainList');
            list.innerHTML = Object.entries(SertiDex.chains).map(([key, chain]) => {
                const cfg = chainConfig[chain.chain_id] || { color: '#6366F1' };
                const isActive = chain.chain_id === SertiDex.currentChainId;

                return `
                    <div class="token-list-item" onclick="selectChain(${chain.chain_id})" style="${isActive ? 'background: rgba(99, 102, 241, 0.2);' : ''}">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: ${cfg.color}; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: 700;">${chain.native_symbol?.charAt(0) || 'C'}</span>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600;">${chain.name}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Chain ID: ${chain.chain_id}</div>
                        </div>
                        ${isActive ? '<span style="color: var(--success);">✓</span>' : ''}
                    </div>
                `;
            }).join('');

            document.getElementById('chainModal').classList.add('active');
        }

        function closeChainModal() {
            document.getElementById('chainModal').classList.remove('active');
        }

        function closeChainModalOutside(e) {
            if (e.target.id === 'chainModal') closeChainModal();
        }

        async function selectChain(chainId) {
            if (chainId === SertiDex.currentChainId) {
                closeChainModal();
                return;
            }

            if (window.ethereum && SertiDex.wallet) {
                try {
                    await window.ethereum.request({
                        method: 'wallet_switchEthereumChain',
                        params: [{ chainId: '0x' + chainId.toString(16) }],
                    });
                } catch (e) {
                    if (e.code === 4902) {
                        const configs = {
                            11155111: { chainId: '0xaa36a7', chainName: 'Sepolia', nativeCurrency: { name: 'ETH', symbol: 'ETH', decimals: 18 }, rpcUrls: ['https://rpc.sepolia.org'], blockExplorerUrls: ['https://sepolia.etherscan.io'] },
                            80002: { chainId: '0x13882', chainName: 'Polygon Amoy', nativeCurrency: { name: 'MATIC', symbol: 'MATIC', decimals: 18 }, rpcUrls: ['https://rpc-amoy.polygon.technology'], blockExplorerUrls: ['https://amoy.polygonscan.com'] },
                        };
                        if (configs[chainId]) {
                            await window.ethereum.request({ method: 'wallet_addEthereumChain', params: [configs[chainId]] });
                        }
                    }
                }
            }

            closeChainModal();
            window.location.href = `${window.location.pathname}?chain=${chainId}`;
        }

        // Token Modal
        let tokenSelectCallback = null;

        function openTokenModal(callback) {
            tokenSelectCallback = callback;
            renderTokenList(SertiDex.tokens);
            document.getElementById('tokenModal').classList.add('active');
        }

        function closeTokenModal() {
            document.getElementById('tokenModal').classList.remove('active');
            tokenSelectCallback = null;
        }

        function closeTokenModalOutside(e) {
            if (e.target.id === 'tokenModal') closeTokenModal();
        }

        function renderTokenList(tokens) {
            document.getElementById('tokenList').innerHTML = tokens.map(token => `
                <div class="token-list-item" onclick='selectToken(${JSON.stringify(token)})'>
                    <img src="${token.logo_url || '/images/tokens/default.svg'}" alt="${token.symbol}" onerror="this.src='/images/tokens/default.svg'">
                    <div style="flex: 1;">
                        <div style="font-weight: 600;">${token.symbol}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">${token.name}</div>
                    </div>
                    <div style="text-align: right; font-size: 0.85rem; color: var(--text-muted);">
                        ${SertiDex.balances[token.symbol] || '0.00'}
                    </div>
                </div>
            `).join('');
        }

        function filterTokens() {
            const search = document.getElementById('tokenSearch').value.toLowerCase();
            renderTokenList(SertiDex.tokens.filter(t => t.symbol.toLowerCase().includes(search) || t.name.toLowerCase().includes(search)));
        }

        function selectToken(token) {
            if (tokenSelectCallback) tokenSelectCallback(token);
            closeTokenModal();
        }

        // Toast
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            container.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }
    </script>

    @yield('scripts')
</body>
</html>
