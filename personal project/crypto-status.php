<?php
/* Template Name: Crypto Status */
get_header();
?>
<main>
    <div class="card">
        <h1>Crypto Status: Ups & Downs</h1>
        <p>Track the latest status, price changes, and trends for popular cryptocurrencies.</p>
        <table style="width:100%; border-collapse:collapse; margin-top:2rem;">
            <thead>
                <tr style="background:#f3e8ff; color:#7c3aed;">
                    <th style="padding:10px;">Cryptocurrency</th>
                    <th style="padding:10px;">Current Price</th>
                    <th style="padding:10px;">24h Change</th>
                    <th style="padding:10px;">Trend</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bitcoin (BTC)</td>
                    <td style="color:#f7931a;">$00,000.00</td>
                    <td style="color:#e53e3e;">-2.5%</td>
                    <td>▼ Down</td>
                </tr>
                <tr>
                    <td>Ethereum (ETH)</td>
                    <td style="color:#627eea;">$0,000.00</td>
                    <td style="color:#38a169;">+1.2%</td>
                    <td>▲ Up</td>
                </tr>
                <tr>
                    <td>Solana (SOL)</td>
                    <td style="color:#00ffa3;">$000.00</td>
                    <td style="color:#e53e3e;">-0.8%</td>
                    <td>▼ Down</td>
                </tr>
                <tr>
                    <td>Other</td>
                    <td>$0.00</td>
                    <td>0.0%</td>
                    <td>Stable</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:2rem; color:#888; font-size:0.98rem;">*Data shown is for demonstration. For live prices, integrate with a crypto API.</p>
    </div>
</main>
<?php
get_footer();
?>