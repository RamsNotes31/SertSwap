<?php
namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class SwapController extends Controller
{
    /**
     * Display the swap interface.
     */
    public function index(Request $request)
    {
        $chainId = $request->get('chain', config('chains.sepolia.chain_id'));
        $chains  = collect(config('chains'))
            ->filter(fn($c) => isset($c['chain_id']))
            ->map(fn($c, $key) => array_merge($c, ['key' => $key]));

        $tokens = Token::forChain($chainId)->active()->get();

        return view('swap.index', [
            'chains'         => $chains,
            'currentChainId' => $chainId,
            'tokens'         => $tokens,
            'chainsJson'     => $chains->values()->toJson(),
            'tokensJson'     => $tokens->toJson(),
        ]);
    }

    /**
     * Get swap quote
     */
    public function getQuote(Request $request)
    {
        $validated = $request->validate([
            'chain_id'  => 'required|integer',
            'token_in'  => 'required|string',
            'token_out' => 'required|string',
            'amount_in' => 'required|numeric|min:0',
        ]);

        $tokenIn = Token::where('address', $validated['token_in'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        $tokenOut = Token::where('address', $validated['token_out'])
            ->where('chain_id', $validated['chain_id'])
            ->first();

        if (! $tokenIn || ! $tokenOut) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        // Simple price calculation based on USD prices
        // In production, this would call the DEX contract for real quotes
        $amountIn  = floatval($validated['amount_in']);
        $valueUsd  = $amountIn * ($tokenIn->price_usd ?? 1);
        $amountOut = $valueUsd / ($tokenOut->price_usd ?? 1);

        // Apply 0.3% fee
        $fee               = $amountOut * 0.003;
        $amountOutAfterFee = $amountOut - $fee;

                                                 // Calculate price impact (mock - would be based on liquidity depth)
        $priceImpact = min($amountIn * 0.01, 5); // Max 5% for demo

        return response()->json([
            'amount_out'     => number_format($amountOutAfterFee, 8, '.', ''),
            'amount_out_min' => number_format($amountOutAfterFee * 0.995, 8, '.', ''), // 0.5% slippage
            'price_impact'   => round($priceImpact, 2),
            'fee'            => number_format($fee, 8, '.', ''),
            'rate'           => number_format($amountOutAfterFee / $amountIn, 6, '.', ''),
            'token_in'       => $tokenIn,
            'token_out'      => $tokenOut,
        ]);
    }
}
