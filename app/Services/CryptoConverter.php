<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CryptoConverter
{
    protected $apiUrl = 'https://api.coingecko.com/api/v3';

    public function convertToCrypto($amount, $symbol)
    {
        // Validate input
        if (!is_numeric($amount) || $amount <= 0) {
            Log::warning("Invalid amount provided for conversion: {$amount}");
            return 0;
        }

        // Get the coin ID from the symbol
        $coinId = $this->getCoinId($symbol);
        if (!$coinId) {
            Log::warning("Unsupported cryptocurrency symbol: {$symbol}");
            return 0;
        }

        try {
            // Get current price (cached for 1 minute)
            $price = Cache::remember("crypto_price_{$coinId}", 60, function () use ($coinId) {
                $response = Http::get("{$this->apiUrl}/simple/price", [
                    'ids' => $coinId,
                    'vs_currencies' => 'usd',
                    'precision' => 'full' // Request full precision
                ]);

                if ($response->failed()) {
                    Log::error("CoinGecko API request failed: " . $response->status());
                    return 0;
                }

                $data = $response->json();
                return $data[$coinId]['usd'] ?? 0;
            });

            if ($price <= 0) {
                Log::error("Invalid price returned for {$coinId}: {$price}");
                return 0;
            }

            // Calculate with high precision
            $cryptoAmount = bcdiv($amount, $price, 18);

            return $cryptoAmount;
        } catch (\Exception $e) {
            Log::error("Crypto conversion error: " . $e->getMessage());
            return 0;
        }
    }

    protected function getCoinId($symbol)
    {
        $symbol = strtoupper($symbol);

        // Handle USDT variants (TRC20/ERC20)
        if (str_starts_with($symbol, 'USDT')) {
            return 'tether';
        }

        // Handle USDC variants
        if (str_starts_with($symbol, 'USDC')) {
            return 'usd-coin';
        }

        $coinMap = [
            'BTC' => 'bitcoin',
            'ETH' => 'ethereum',
            'USDT' => 'tether',
            'USDC' => 'usd-coin',
            'BNB' => 'binancecoin',
            'XRP' => 'ripple',
            'SOL' => 'solana',
            'ADA' => 'cardano',
            'DOGE' => 'dogecoin',
            'DOT' => 'polkadot',
            'SHIB' => 'shiba-inu',
            'TRX' => 'tron',
            'AVAX' => 'avalanche-2',
            'MATIC' => 'matic-network',
            'LINK' => 'chainlink',
            'ATOM' => 'cosmos',
            'XLM' => 'stellar',
            'XMR' => 'monero',
            'ETC' => 'ethereum-classic',
            'BCH' => 'bitcoin-cash',
            'LTC' => 'litecoin',
        ];

        return $coinMap[$symbol] ?? null;
    }
}
