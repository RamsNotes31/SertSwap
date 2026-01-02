<p align="center">
  <img src="https://img.shields.io/badge/🔄-SertSwap-6366f1?style=for-the-badge&labelColor=1a1a2e" alt="SertSwap Logo" />
</p>

<h1 align="center">
  <span>🌊 SertSwap DEX</span>
</h1>

<p align="center">
  <em>Decentralized Token Exchange Platform untuk Testnet</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 11" />
  <img src="https://img.shields.io/badge/Ethers.js-6.x-3C3C3D?style=flat-square&logo=ethereum&logoColor=white" alt="Ethers.js" />
  <img src="https://img.shields.io/badge/Network-Sepolia%20|%20Amoy-8247E5?style=flat-square&logo=ethereum&logoColor=white" alt="Networks" />
  <img src="https://img.shields.io/badge/Protocol-Uniswap%20V2-FF007A?style=flat-square&logo=uniswap&logoColor=white" alt="Uniswap V2" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-In%20Development-yellow?style=flat-square" alt="Status" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="License" />
</p>

---

## ⚡ Apa itu SertSwap?

**SertSwap** adalah platform decentralized exchange (DEX) yang dibangun di atas Laravel dengan integrasi Web3 menggunakan Ethers.js. Platform ini memungkinkan pengguna untuk:

-   🔄 **Swap Token** - Tukar token ERC-20 secara langsung menggunakan protokol Uniswap V2
-   💧 **Liquidity Pools** - Tambah dan kelola likuiditas untuk pasangan token
-   👛 **Multi-Wallet Support** - Koneksi dengan MetaMask dan wallet Web3 lainnya
-   📊 **Real-time Quotes** - Dapatkan harga swap secara real-time

---

## 🎯 Fitur Utama

<table>
<tr>
<td width="50%">

### 🔄 Token Swap

-   Swap ETH/MATIC ke token ERC-20
-   Swap token ERC-20 ke ETH/MATIC
-   Swap antar token ERC-20
-   Slippage tolerance yang bisa dikustomisasi
-   Transaction deadline setting

</td>
<td width="50%">

### 💧 Liquidity Management

-   Tambah likuiditas ke pool
-   Hapus likuiditas dari pool
-   Lihat posisi likuiditas
-   Calculate optimal amounts

</td>
</tr>
<tr>
<td width="50%">

### 🌐 Multi-Network

-   **Sepolia Testnet** (Ethereum)
-   **Amoy Testnet** (Polygon)
-   Network switching yang mudah
-   Block explorer integration

</td>
<td width="50%">

### 📱 User Experience

-   Dark/Light mode responsive
-   Real-time balance updates
-   Transaction history tracking
-   Glassmorphism UI design

</td>
</tr>
</table>

---

## 🛠️ Tech Stack

| Layer               | Technology                   |
| ------------------- | ---------------------------- |
| **Backend**         | Laravel 11, PHP 8.2+         |
| **Frontend**        | Blade Templates, Vanilla CSS |
| **Blockchain**      | Ethers.js v6, Web3 Provider  |
| **Smart Contracts** | Uniswap V2 Router, ERC-20    |
| **Database**        | MySQL/SQLite                 |

---

## 🚀 Quick Start

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   MetaMask Extension

### Installation

```bash
# Clone repository
git clone https://github.com/your-username/SertSwap.git
cd SertSwap

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Start development server
php artisan serve
```

### Configuration

Edit file `.env` untuk konfigurasi:

```env
# Application
APP_NAME=SertSwap
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=sertswap
```

---

## 🔗 Supported Networks

| Network     | Chain ID | Router Contract | Explorer                                        |
| ----------- | -------- | --------------- | ----------------------------------------------- |
| **Sepolia** | 11155111 | Uniswap V2      | [etherscan.io](https://sepolia.etherscan.io)    |
| **Amoy**    | 80002    | QuickSwap       | [polygonscan.com](https://amoy.polygonscan.com) |

---

## 📁 Project Structure

```
SertSwap/
├── app/
│   ├── Http/Controllers/
│   │   ├── SwapController.php      # Swap logic
│   │   ├── LiquidityController.php # Liquidity management
│   │   └── Api/TokenController.php # Token API
│   └── Models/
│       ├── Token.php               # Token model
│       └── Pool.php                # Liquidity pool model
├── public/
│   └── js/
│       └── web3-service.js         # Web3 interactions
├── resources/
│   └── views/
│       ├── swap/                   # Swap interface
│       ├── liquidity/              # Liquidity interface
│       └── layouts/                # App layout
└── routes/
    ├── web.php                     # Web routes
    └── api.php                     # API routes
```

---

## 🎨 UI Preview

```
┌──────────────────────────────────────┐
│         🔄 SertSwap DEX              │
├──────────────────────────────────────┤
│  ┌────────────────────────────────┐  │
│  │  You Pay                       │  │
│  │  [1.0        ] [ETH ▼]        │  │
│  │  Balance: 2.5 ETH             │  │
│  └────────────────────────────────┘  │
│              ⇅                       │
│  ┌────────────────────────────────┐  │
│  │  You Receive                   │  │
│  │  [1842.50    ] [USDC ▼]       │  │
│  │  Balance: 500 USDC            │  │
│  └────────────────────────────────┘  │
│                                      │
│  ┌────────────────────────────────┐  │
│  │        [ Swap Now ]            │  │
│  └────────────────────────────────┘  │
└──────────────────────────────────────┘
```

---

## 🔐 Security

> ⚠️ **Testnet Only**: Platform ini dirancang untuk digunakan di testnet saja. Jangan gunakan untuk transaksi mainnet dengan aset nyata.

-   ✅ Non-custodial - Private keys tidak pernah meninggalkan wallet Anda
-   ✅ Open source - Kode dapat diaudit
-   ✅ Standard ERC-20 - Menggunakan kontrak yang sudah teruji

---

## 🤝 Contributing

Kontribusi sangat dihargai! Silakan:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

## 👤 Author

**Muham**

-   🌐 Built with ❤️ for Web3 community
-   📧 Contact: [your-email@example.com]

---

<p align="center">
  <img src="https://img.shields.io/badge/Made%20with-Laravel%20%26%20Web3-6366f1?style=for-the-badge" alt="Made with Laravel & Web3" />
</p>

<p align="center">
  <sub>⭐ Star this repo if you find it useful!</sub>
</p>
