








<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CryptoConverter
{
    protected $coinGeckoUrl = 'https://api.coingecko.com/api/v3';
    protected $coinMarketCapUrl = 'https://pro-api.coinmarketcap.com/v1';
    protected $primarySource = 'coinmarketcap'; // Can be 'coinmarketcap' or 'coingecko'

    public function convertToCrypto($amount, $symbol)
    {
        // Validate input
        if (!is_numeric($amount) || $amount <= 0) {
            Log::warning("Invalid amount provided for conversion: {$amount}");
            return 0;
        }

        try {
            // Try primary source first
            $price = $this->getCurrentPrice($symbol);

            if ($price <= 0) {
                // Fallback to secondary source
                $price = $this->getFallbackPrice($symbol);

                if ($price <= 0) {
                    Log::error("Failed to get valid price for {$symbol} from all sources");
                    return 0;
                }
            }

            // Calculate with high precision
            return bcdiv($amount, $price, 18);
        } catch (\Exception $e) {
            Log::error("Crypto conversion error: " . $e->getMessage());
            return 0;
        }
    }

    protected function getCurrentPrice($symbol)
    {
        $cacheKey = "crypto_price_{$this->primarySource}_{$symbol}";

        return Cache::remember($cacheKey, 60, function () use ($symbol) {
            if ($this->primarySource === 'coinmarketcap') {
                return $this->getCoinMarketCapPrice($symbol);
            }

            return $this->getCoinGeckoPrice($symbol);
        });
    }

    protected function getFallbackPrice($symbol)
    {
        $cacheKey = "crypto_price_fallback_{$symbol}";

        return Cache::remember($cacheKey, 60, function () use ($symbol) {
            if ($this->primarySource === 'coinmarketcap') {
                $price = $this->getCoinGeckoPrice($symbol);
                if ($price > 0) return $price;
            } else {
                $price = $this->getCoinMarketCapPrice($symbol);
                if ($price > 0) return $price;
            }

            // Ultimate fallback - check Binance or other exchange
            return $this->getBinancePrice($symbol);
        });
    }

    protected function getCoinMarketCapPrice($symbol)
    {
        $apiKey = config('services.coinmarketcap.api_key');
        if (empty($apiKey)) {
            Log::warning("CoinMarketCap API key not configured");
            return 0;
        }

        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
            'Accept' => 'application/json'
        ])->get("{$this->coinMarketCapUrl}/cryptocurrency/quotes/latest", [
            'symbol' => $this->normalizeSymbol($symbol),
            'convert' => 'USD'
        ]);

        if ($response->failed()) {
            Log::error("CoinMarketCap API request failed: " . $response->status());
            return 0;
        }

        $data = $response->json();
        $normalizedSymbol = $this->normalizeSymbol($symbol);

        return $data['data'][$normalizedSymbol]['quote']['USD']['price'] ?? 0;
    }

    protected function getCoinGeckoPrice($symbol)
    {
        $coinId = $this->getCoinId($symbol);
        if (!$coinId) return 0;

        $response = Http::get("{$this->coinGeckoUrl}/simple/price", [
            'ids' => $coinId,
            'vs_currencies' => 'usd',
            'precision' => 'full'
        ]);

        if ($response->failed()) {
            Log::error("CoinGecko API request failed: " . $response->status());
            return 0;
        }

        $data = $response->json();
        return $data[$coinId]['usd'] ?? 0;
    }

    protected function getBinancePrice($symbol)
    {
        $normalizedSymbol = $this->normalizeSymbol($symbol) . 'USDT';

        try {
            $response = Http::get("https://api.binance.com/api/v3/ticker/price", [
                'symbol' => $normalizedSymbol
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Get USDT price from Binance
                $usdtPrice = $this->getUSDTPrice();
                return $data['price'] * $usdtPrice;
            }
        } catch (\Exception $e) {
            Log::error("Binance API error: " . $e->getMessage());
        }

        return 0;
    }

    protected function getUSDTPrice()
    {
        // USDT is usually pegged to 1 USD, but we can verify
        return Cache::remember('usdt_price', 3600, function () {
            $response = Http::get("https://api.binance.com/api/v3/ticker/price", [
                'symbol' => 'USDUSDT'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['price'] ?? 1;
            }

            return 1; // Default to 1 if API fails
        });
    }

    protected function normalizeSymbol($symbol)
    {
        // Extract base symbol (remove network identifiers)
        if (str_starts_with($symbol, 'USDT') || str_starts_with($symbol, 'USDC')) {
            return substr($symbol, 0, 4);
        }
        return $symbol;
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
