<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Prices</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<h1>Real-Time Stock Prices</h1>
<div id="stock-prices">
    <div id="AAPL-price">AAPL: $0.00</div>
    <div id="MSFT-price">MSFT: $0.00</div>
    <div id="AMZN-price">AMZN: $0.00</div>
    <div id="GOOGL-price">GOOGL: $0.00</div>
    <div id="TSLA-price">TSLA: $0.00</div>
    <div id="META-price">META: $0.00</div>
    <div id="BRK.B-price">BRK.B: $0.00</div>
    <div id="JNJ-price">JNJ: $0.00</div>
    <div id="JPM-price">JPM: $0.00</div>
    <div id="V-price">V: $0.00</div>
</div>

<script>
    if (window.Echo) {
        window.Echo.channel('stock-prices')
            .listen('.StockPriceUpdated', (e) => {
                console.log(e);
                var stockElement = document.getElementById(e.symbol + '-price');
                if (stockElement) {
                    stockElement.innerText = e.symbol + ': $' + e.price.toFixed(2);
                }
            });
    }
</script>
</body>
</html>
