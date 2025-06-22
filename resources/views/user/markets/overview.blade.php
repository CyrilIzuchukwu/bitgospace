@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">


        <div class="markets-overview">
            <div class="row">
                <!-- Original Widgets -->
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:BTCUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:ETHUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:XRPUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:BNBUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:ADAUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:DOGEUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:DOTUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:SOLUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>

                <!-- Additional Cryptocurrency Widgets -->
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:LTCUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:AVAXUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:LINKUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:ATOMUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:UNIUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:ALGOUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-md-4 mb30">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript"
                            src="{{ asset('dashboard_assets/assets/embeded/embed-widget-mini-symbol-overview.js') }}" async>
                            {
                                "symbol": "BINANCE:ETCUSDT",
                                "width": "100%",
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "trendLineColor": "rgba(41, 98, 255, 1)",
                                "underLineColor": "rgba(41, 98, 255, 0.3)",
                                "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>


    </div> <!-- container -->
    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>

<style>
    html.theme-dark .tv-embed-widget-wrapper__body {
        background: var(--tv-widget-background-color, #1f1f1f);
        background: red !important;
        border-color: #4a4a4a
    }
</style>


@endsection
