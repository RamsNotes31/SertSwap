<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Get tokens for a specific chain
     */
    public function index(Request $request)
    {
        $chainId = $request->get('chain_id', config('chains.sepolia.chain_id'));

        $tokens = Token::forChain($chainId)
            ->active()
            ->orderBy('is_native', 'desc')
            ->orderBy('symbol')
            ->get();

        return response()->json([
            'tokens' => $tokens,
            'count'  => $tokens->count(),
        ]);
    }

    /**
     * Get a single token by address
     */
    public function show(Request $request, string $address)
    {
        $chainId = $request->get('chain_id', config('chains.sepolia.chain_id'));

        $token = Token::where('address', $address)
            ->where('chain_id', $chainId)
            ->first();

        if (! $token) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        return response()->json($token);
    }

    /**
     * Get supported chains
     */
    public function chains()
    {
        $chains = collect(config('chains'))
            ->filter(fn($c) => isset($c['chain_id']))
            ->map(fn($c, $key) => [
                'key'           => $key,
                'chain_id'      => $c['chain_id'],
                'name'          => $c['name'],
                'short_name'    => $c['short_name'],
                'native_symbol' => $c['native_symbol'],
                'explorer'      => $c['explorer'],
                'icon'          => $c['icon'] ?? null,
            ])
            ->values();

        return response()->json([
            'chains'  => $chains,
            'default' => config('chains.default'),
        ]);
    }

    /**
     * Get transaction history for wallet
     */
    public function transactions(Request $request)
    {
        $validated = $request->validate([
            'wallet'   => 'required|string|size:42',
            'chain_id' => 'nullable|integer',
            'type'     => 'nullable|in:swap,add_liquidity,remove_liquidity',
        ]);

        $query = Transaction::forWallet($validated['wallet'])
            ->with(['tokenIn', 'tokenOut', 'pool.token0', 'pool.token1'])
            ->orderBy('created_at', 'desc')
            ->limit(50);

        if (isset($validated['chain_id'])) {
            $query->forChain($validated['chain_id']);
        }

        if (isset($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        $transactions = $query->get();

        return response()->json([
            'transactions' => $transactions,
            'count'        => $transactions->count(),
        ]);
    }

    /**
     * Store a new transaction record
     */
    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'tx_hash'           => 'required|string|size:66|unique:transactions',
            'wallet_address'    => 'required|string|size:42',
            'type'              => 'required|in:swap,add_liquidity,remove_liquidity',
            'chain_id'          => 'required|integer',
            'token_in_address'  => 'nullable|string',
            'token_out_address' => 'nullable|string',
            'amount_in'         => 'nullable|numeric',
            'amount_out'        => 'nullable|numeric',
            'value_usd'         => 'nullable|numeric',
        ]);

        $tokenIn  = null;
        $tokenOut = null;

        if (isset($validated['token_in_address'])) {
            $tokenIn = Token::where('address', $validated['token_in_address'])
                ->where('chain_id', $validated['chain_id'])
                ->first();
        }

        if (isset($validated['token_out_address'])) {
            $tokenOut = Token::where('address', $validated['token_out_address'])
                ->where('chain_id', $validated['chain_id'])
                ->first();
        }

        $transaction = Transaction::create([
            'tx_hash'        => $validated['tx_hash'],
            'wallet_address' => strtolower($validated['wallet_address']),
            'type'           => $validated['type'],
            'chain_id'       => $validated['chain_id'],
            'token_in_id'    => $tokenIn?->id,
            'token_out_id'   => $tokenOut?->id,
            'amount_in'      => $validated['amount_in'] ?? null,
            'amount_out'     => $validated['amount_out'] ?? null,
            'value_usd'      => $validated['value_usd'] ?? null,
            'status'         => 'pending',
        ]);

        return response()->json($transaction, 201);
    }
}
