<?php
get_header();
?>
<main>
    <div class="card">
        <h1>Welcome to Personal Finance Tracker</h1>
    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80" alt="Finances" style="width:100%;max-width:400px;border-radius:12px;margin-bottom:1.5rem;box-shadow:0 2px 12px rgba(34,34,59,0.10);">
        <p>This is your home dashboard. Track your finances, view insights, and manage your goals.</p>
        <div style="margin:2rem 0; display:flex; gap:2rem; flex-wrap:wrap; justify-content:center;">
            <a href="<?php echo home_url('/profile'); ?>" class="home-link-btn">Your Profile</a>
            <a href="<?php echo home_url('/rateus'); ?>" class="home-link-btn">Rate Us</a>
            <a href="<?php echo home_url('/about-us'); ?>" class="home-link-btn">About Us</a>
        </div>
        <div class="summary" style="background:#ebf8ff; padding:1.5rem; border-radius:10px; margin-bottom:2rem;">
            <h2 style="margin-top:0;">Quick Financial Summary</h2>
            <?php
            // Handle form submissions
            if (isset($_POST['submit_income'])) {
                $amount = floatval($_POST['add_income']);
                if ($amount > 0) {
                    $current = get_option('ppt_income', 0);
                    update_option('ppt_income', $current + $amount);
                    echo '<p style="color:#38a169;">Added $' . number_format($amount,2) . ' to income!</p>';
                }
            }
            if (isset($_POST['submit_expense'])) {
                $amount = floatval($_POST['add_expense']);
                if ($amount > 0) {
                    $current = get_option('ppt_expense', 0);
                    update_option('ppt_expense', $current + $amount);
                    echo '<p style="color:#e53e3e;">Added $' . number_format($amount,2) . ' to expenses!</p>';
                }
            }
            $total_income = get_option('ppt_income', 0);
            $total_expense = get_option('ppt_expense', 0);
            $balance = $total_income - $total_expense;
            ?>
            <ul style="list-style:none; padding:0;">
                <li><strong>Total Income:</strong> <span style="color:#38a169;">$<?php echo number_format($total_income,2); ?></span></li>
                <li><strong>Total Expenses:</strong> <span style="color:#e53e3e;">$<?php echo number_format($total_expense,2); ?></span></li>
                <li><strong>Balance:</strong> <span style="color:#3182ce;">$<?php echo number_format($balance,2); ?></span></li>
            </ul>
            <form method="post" style="margin-top:1.5rem; display:inline-block; margin-right:2rem;">
                <h3>Add Income</h3>
                <input type="number" name="add_income" min="0" step="0.01" placeholder="Amount" required style="padding:0.5rem; border-radius:6px; border:1px solid #ccc;">
                <button type="submit" name="submit_income">Add Income</button>
            </form>
            <form method="post" style="margin-top:1.5rem; display:inline-block;">
                <h3>Add Expense</h3>
                <input type="number" name="add_expense" min="0" step="0.01" placeholder="Amount" required style="padding:0.5rem; border-radius:6px; border:1px solid #ccc;">
                <button type="submit" name="submit_expense">Add Expense</button>
            </form>
        </div>
        <div class="summary" style="background:#f3e8ff; padding:1.5rem; border-radius:10px; margin-bottom:2rem;">
            <h2 style="margin-top:0; color:#7c3aed;">Crypto Portfolio</h2>
            <?php
            // Handle add crypto form
            if (isset($_POST['submit_crypto'])) {
                $symbol = strtoupper(trim($_POST['crypto_symbol']));
                $amount = floatval($_POST['add_crypto']);
                if ($amount > 0 && preg_match('/^[A-Z0-9]{2,10}$/', $symbol)) {
                    $crypto_list = get_option('ppt_crypto_list', array());
                    if (!isset($crypto_list[$symbol])) {
                        $crypto_list[$symbol] = 0;
                    }
                    $crypto_list[$symbol] += $amount;
                    update_option('ppt_crypto_list', $crypto_list);
                    echo '<p style="color:#7c3aed;">Added ' . number_format($amount,4) . ' to ' . strtoupper($symbol) . '!</p>';
                }
            }

            // Handle search form
            $crypto_list = get_option('ppt_crypto_list', array('BTC'=>0,'ETH'=>0));
            $search_result = '';
            if (isset($_POST['search_crypto_btn']) && !empty($_POST['search_crypto'])) {
                $search = strtoupper(trim($_POST['search_crypto']));
                if (array_key_exists($search, $crypto_list)) {
                    $search_result = '<p><strong>' . $search . ':</strong> ' . number_format($crypto_list[$search], 4) . '</p>';
                } else {
                    $search_result = '<p style="color:#e53e3e;">Crypto not found in your portfolio.</p>';
                }
            }
            ?>
            <form method="post" style="margin-bottom:1.5rem; display:flex; gap:1rem; flex-wrap:wrap; align-items:center;">
                <input type="text" name="search_crypto" placeholder="Search crypto (e.g. BTC, ETH, DOGE)" style="padding:0.5rem; border-radius:6px; border:1px solid #ccc; min-width:180px;">
                <button type="submit" name="search_crypto_btn">Search</button>
            </form>
            <?php echo $search_result; ?>
            <ul style="list-style:none; padding:0;">
                <?php
                foreach ($crypto_list as $symbol => $amount) {
                    echo '<li><strong>' . strtoupper($symbol) . ':</strong> <span style="color:#7c3aed;">' . number_format($amount, 4) . '</span></li>';
                }
                ?>
            </ul>
            <form method="post" style="margin-top:1.5rem;">
                <h3>Add to Crypto Portfolio</h3>
                <input type="text" name="crypto_symbol" placeholder="Symbol (e.g. BTC, ETH, DOGE)" required style="padding:0.5rem; border-radius:6px; border:1px solid #ccc; min-width:120px;">
                <input type="number" name="add_crypto" min="0" step="0.0001" placeholder="Amount" required style="padding:0.5rem; border-radius:6px; border:1px solid #ccc;">
                <button type="submit" name="submit_crypto">Add Crypto</button>
            </form>
        </div>
        <blockquote style="font-style:italic; color:#4f8cff; border-left:4px solid #4f8cff; padding-left:1rem; margin:2rem 0 0 0;">“The secret to getting ahead is getting started.”</blockquote>
    </div>
</main>
<?php
get_footer();
?>