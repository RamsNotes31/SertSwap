<?php
namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Seed test tokens for Sepolia and Amoy testnets.
     */
    public function run(): void
    {
        $tokens = [
            // Sepolia Tokens (Chain ID: 11155111)
            [
                'symbol'            => 'ETH',
                'name'              => 'Ethereum',
                'address'           => '0x0000000000000000000000000000000000000000',
                'decimals'          => 18,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/eth.svg',
                'is_native'         => true,
                'is_wrapped_native' => false,
                'price_usd'         => 2500.00,
            ],
            [
                'symbol'            => 'WETH',
                'name'              => 'Wrapped Ether',
                'address'           => '0x7b79995e5f793A07Bc00c21412e50Ecae098E7f9',
                'decimals'          => 18,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/weth.svg',
                'is_native'         => false,
                'is_wrapped_native' => true,
                'price_usd'         => 2500.00,
            ],
            [
                'symbol'            => 'USDC',
                'name'              => 'USD Coin',
                'address'           => '0x1c7D4B196Cb0C7B01d743Fbc6116a902379C7238',
                'decimals'          => 6,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/usdc.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'USDT',
                'name'              => 'Tether USD',
                'address'           => '0xaA8E23Fb1079EA71e0a56F48a2aA51851D8433D0',
                'decimals'          => 6,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/usdt.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'DAI',
                'name'              => 'Dai Stablecoin',
                'address'           => '0x68194a729C2450ad26072b3D33ADaCbcef39D574',
                'decimals'          => 18,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/dai.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'LINK',
                'name'              => 'Chainlink',
                'address'           => '0x779877A7B0D9E8603169DdbD7836e478b4624789',
                'decimals'          => 18,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/link.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 15.00,
            ],
            [
                'symbol'            => 'UNI',
                'name'              => 'Uniswap',
                'address'           => '0x1f9840a85d5aF5bf1D1762F925BDADdC4201F984',
                'decimals'          => 18,
                'chain_id'          => 11155111,
                'logo_url'          => '/images/tokens/uni.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 7.50,
            ],

            // Amoy Tokens (Chain ID: 80002)
            [
                'symbol'            => 'MATIC',
                'name'              => 'Polygon',
                'address'           => '0x0000000000000000000000000000000000000000',
                'decimals'          => 18,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/matic.svg',
                'is_native'         => true,
                'is_wrapped_native' => false,
                'price_usd'         => 0.85,
            ],
            [
                'symbol'            => 'WMATIC',
                'name'              => 'Wrapped Matic',
                'address'           => '0x360ad4f9a9A8EFe9A8DCB5f461c4Cc1047E1Dcf9',
                'decimals'          => 18,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/wmatic.svg',
                'is_native'         => false,
                'is_wrapped_native' => true,
                'price_usd'         => 0.85,
            ],
            [
                'symbol'            => 'USDC',
                'name'              => 'USD Coin',
                'address'           => '0x41E94Eb019C0762f9Bfcf9Fb1E58725BfB0e7582',
                'decimals'          => 6,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/usdc.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'USDT',
                'name'              => 'Tether USD',
                'address'           => '0x1616d425Cd540B256475cBfb604586C8598eC0FB',
                'decimals'          => 6,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/usdt.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'DAI',
                'name'              => 'Dai Stablecoin',
                'address'           => '0xC87385b5E62099f92d490750Fcd6C901a524BBcA',
                'decimals'          => 18,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/dai.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 1.00,
            ],
            [
                'symbol'            => 'WBTC',
                'name'              => 'Wrapped Bitcoin',
                'address'           => '0x75E0E92A79880Bd81A69F72983D03c75e2B33dC4',
                'decimals'          => 8,
                'chain_id'          => 80002,
                'logo_url'          => '/images/tokens/wbtc.svg',
                'is_native'         => false,
                'is_wrapped_native' => false,
                'price_usd'         => 45000.00,
            ],
        ];

        foreach ($tokens as $token) {
            Token::updateOrCreate(
                ['address' => $token['address'], 'chain_id' => $token['chain_id']],
                $token
            );
        }
    }
}
