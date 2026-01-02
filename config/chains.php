<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supported Blockchain Networks
    |--------------------------------------------------------------------------
    |
    | Configuration for each supported EVM testnet including RPC endpoints,
    | DEX router addresses, and explorer URLs.
    |
    */

    'sepolia' => [
        'chain_id'        => 11155111,
        'name'            => 'Sepolia Testnet',
        'short_name'      => 'Sepolia',
        'rpc_url'         => env('SEPOLIA_RPC_URL', 'https://eth-sepolia.g.alchemy.com/v2/demo'),
        'explorer'        => 'https://sepolia.etherscan.io',
        'native_symbol'   => 'ETH',
        'native_decimals' => 18,
        'native_logo'     => '/images/tokens/eth.svg',
        // Uniswap V2 on Sepolia
        'router_address'  => '0xeE567Fe1712Faf6149d80dA1E6934E354124CfE3',
        'factory_address' => '0xF62c03E08ada871A0bEb309762E260a7a6a880E6',
        'weth_address'    => '0x7b79995e5f793A07Bc00c21412e50Ecae098E7f9',
        'icon'            => '/images/chains/sepolia.svg',
    ],

    'amoy'    => [
        'chain_id'        => 80002,
        'name'            => 'Polygon Amoy Testnet',
        'short_name'      => 'Amoy',
        'rpc_url'         => env('AMOY_RPC_URL', 'https://rpc-amoy.polygon.technology'),
        'explorer'        => 'https://amoy.polygonscan.com',
        'native_symbol'   => 'MATIC',
        'native_decimals' => 18,
        'native_logo'     => '/images/tokens/matic.svg',
        // QuickSwap on Amoy
        'router_address'  => '0xa5E0829CaCEd8fFDD4De3c43696c57F7D7A678ff',
        'factory_address' => '0x5757371414417b8C6CAad45bAeF941aBc7d3Ab32',
        'wmatic_address'  => '0x360ad4f9a9A8EFe9A8DCB5f461c4Cc1047E1Dcf9',
        'icon'            => '/images/chains/polygon.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Chain
    |--------------------------------------------------------------------------
    */
    'default' => 'sepolia',

    /*
    |--------------------------------------------------------------------------
    | Swap Settings
    |--------------------------------------------------------------------------
    */
    'swap'    => [
        'default_slippage' => 0.5, // 0.5%
        'max_slippage'     => 50,  // 50%
        'deadline_minutes' => 20,
    ],
];
