<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CryptoConverter
{
    protected $apiUrl = 'https://api.coingecko.com/api/v3';

    public function convertToCrypto($amount, $symbol)
    {
        // Get the coin ID from the symbol
        $coinId = $this->getCoinId($symbol);
        if (!$coinId) {
            return 0;
        }

        // Get current price (cached for 1 minute to avoid too many API calls)
        $price = Cache::remember("crypto_price_{$coinId}", 60, function () use ($coinId) {
            try {
                $response = Http::get("{$this->apiUrl}/simple/price", [
                    'ids' => $coinId,
                    'vs_currencies' => 'usd'
                ]);

                $data = $response->json();
                return $data[$coinId]['usd'] ?? 0;
            } catch (\Exception $e) {
                return 0;
            }
        });

        if ($price <= 0) {
            return 0;
        }

        return $amount / $price;
    }

    protected function getCoinId($symbol)
    {
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

        return $coinMap[strtoupper($symbol)] ?? null;
    }
}
