@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="markets-overview">

            <div class="row">
                <div class="col-md-12 mb15">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="{{ asset('dashboard_assets/assets/embeded/embed-widget-ticker-tape.js') }}"
                            async>
                            {
                                "colorTheme": "dark"
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>


                <div class="col-md-12">
                    <div class="main-chart">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div id="tradingview_e8053"></div>
                            <script src="{{ asset('dashboard_assets/assets/embeded/tv.js') }}"></script>
                            <script>
                                new TradingView.widget({
                                    "width": "100%",
                                    "height": 550,
                                    "symbol": "BITSTAMP:BTCUSD",
                                    "interval": "D",
                                    "timezone": "Etc/UTC",
                                    "theme": "Dark",
                                    "style": "1",
                                    "locale": "en",
                                    "toolbar_bg": "#f1f3f6",
                                    "enable_publishing": false,
                                    "withdateranges": true,
                                    "hide_side_toolbar": false,
                                    "allow_symbol_change": true,
                                    "show_popup_button": true,
                                    "popup_width": "1000",
                                    "popup_height": "650",
                                    "container_id": "tradingview_e8053"
                                });
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>

@endsection
