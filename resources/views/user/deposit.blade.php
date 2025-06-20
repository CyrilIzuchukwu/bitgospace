        @extends('layouts.dashboard')
        @section('content')
        <div class="page-content">
            <div class="page-container">
                <div class="">
                    <h2>Deposit Funds</h2>

                    @if(session('error'))
                    <p style="color:red">{{ session('error') }}</p>
                    @endif

                    <form method="POST" action="{{ route('deposit.process') }}">
                        @csrf
                        <div>
                            <label>Amount (USD):</label>
                            <input type="number" name="amount" required step="0.01">
                        </div>

                        <div>
                            <label>Currency:</label>
                            <select name="currency" required>
                                <option value="usd">USD</option>
                                <option value="eur">EUR</option>
                            </select>
                        </div>

                        <button type="submit">Proceed to Pay</button>
                    </form>
                </div>
            </div>
        </div>
        @endsection
