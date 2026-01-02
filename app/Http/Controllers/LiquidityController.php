<?php
namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Token;
use Illuminate\Http\Request;

class LiquidityController extends Controller
{
    /**
     * Display the liquidity interface.
     */
    public function index(Request $request)
    {
        $chainId = $request->get('chain', config('chains.sepolia.chain_id'));
        $chains  = collect(config('chains'))
            ->filter(fn($c) => isset($c['chain_id']))
            ->map(fn($c, $key) => array_merge($c, ['key' => $key]));

        $tokens = Token::forChain($chainId)->active()->get();
        $pools  = Pool::with(['token0', 'token1'])
            ->forChain($chainId)
            ->where('is_active', true)
            ->get();

        return view('liquidity.index', [
            'chains'         => $chains,
            'currentChainId' => $chainId,
            'tokens'         => $tokens,
            'pools'          => $pools,
            'chainsJson'     => $chains->values()->toJson(),
            'tokensJson'     => $tokens->toJson(),
            'poolsJson'      => $pools->toJson(),
        ]);
    }

    /**
     * Get pool information
     */
    public function getPool(Request $request)
    {
        $validated = $request->validate([
            'chain_id' => 'required|integer',
            'token0'   => 'required|string',
            'token1'   => 'required|string',
        ]);

        $token0 = Token::where('address', $validated['token0'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        $token1 = Token::where('address', $validated['token1'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        if (! $token0 || ! $token1) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        $pool = Pool::where(function ($q) use ($token0, $token1) {
            $q->where('token0_id', $token0->id)->where('token1_id', $token1->id);
        })->orWhere(function ($q) use ($token0, $token1) {
            $q->where('token0_id', $token1->id)->where('token1_id', $token0->id);
        })->with(['token0', 'token1'])->first();

        if (! $pool) {
            return response()->json([
                'exists' => false,
                'token0' => $token0,
                'token1' => $token1,
            ]);
        }

        return response()->json([
            'exists'        => true,
            'pool'          => $pool,
            'share_of_pool' => 0, // Would calculate based on user's LP tokens
        ]);
    }

    /**
     * Get add liquidity quote
     */
    public function getAddQuote(Request $request)
    {
        $validated = $request->validate([
            'chain_id' => 'required|integer',
            'token0'   => 'required|string',
            'token1'   => 'required|string',
            'amount0'  => 'required|numeric|min:0',
        ]);

        $token0 = Token::where('address', $validated['token0'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        $token1 = Token::where('address', $validated['token1'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        if (! $token0 || ! $token1) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        // Calculate token1 amount based on price ratio
        $amount0    = floatval($validated['amount0']);
        $priceRatio = ($token0->price_usd ?? 1) / ($token1->price_usd ?? 1);
        $amount1    = $amount0 * $priceRatio;

        // Estimate LP tokens (simplified)
        $totalValueUsd = ($amount0 * ($token0->price_usd ?? 1)) + ($amount1 * ($token1->price_usd ?? 1));
        $estimatedLp   = sqrt($amount0 * $amount1);

        return response()->json([
            'amount0'         => number_format($amount0, 8, '.', ''),
            'amount1'         => number_format($amount1, 8, '.', ''),
            'estimated_lp'    => number_format($estimatedLp, 8, '.', ''),
            'total_value_usd' => number_format($totalValueUsd, 2, '.', ''),
            'share_of_pool'   => '< 0.01%', // New pool share
        ]);
    }
}
