
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Personal Finance Tracker</title>
	<style>
		body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
		.container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 32px; }
		h1 { text-align: center; color: #2d3748; }
		form { display: flex; gap: 12px; margin-bottom: 24px; }
		input, select { padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
		button { background: #3182ce; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
		button:hover { background: #2b6cb0; }
		table { width: 100%; border-collapse: collapse; margin-top: 24px; }
		th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
		th { background: #f7fafc; }
		.summary { margin-top: 32px; background: #ebf8ff; padding: 16px; border-radius: 6px; }
	</style>
</head>
<body>
	<div class="container">
		<h1>Personal Finance Tracker</h1>
		<form id="expense-form">
			<input type="text" id="desc" placeholder="Description" required>
			<input type="number" id="amount" placeholder="Amount" min="0" step="0.01" required>
			<select id="type">
				<option value="income">Income</option>
				<option value="expense">Expense</option>
			</select>
			<button type="submit">Add</button>
		</form>
		<table id="transactions">
			<thead>
				<tr>
					<th>Description</th>
					<th>Amount</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<div class="summary" id="summary">
			<strong>Total Income:</strong> $<span id="total-income">0.00</span><br>
			<strong>Total Expenses:</strong> $<span id="total-expense">0.00</span><br>
			<strong>Balance:</strong> $<span id="balance">0.00</span>
		</div>
	</div>
	<script>
		const form = document.getElementById('expense-form');
		const transactionsTbody = document.querySelector('#transactions tbody');
		const totalIncomeEl = document.getElementById('total-income');
		const totalExpenseEl = document.getElementById('total-expense');
		const balanceEl = document.getElementById('balance');
		let transactions = [];

		form.addEventListener('submit', function(e) {
			e.preventDefault();
			const desc = document.getElementById('desc').value;
			const amount = parseFloat(document.getElementById('amount').value);
			const type = document.getElementById('type').value;
			transactions.push({ desc, amount, type });
			renderTransactions();
			form.reset();
		});

		function renderTransactions() {
			transactionsTbody.innerHTML = '';
			let totalIncome = 0, totalExpense = 0;
			transactions.forEach(tr => {
				const row = document.createElement('tr');
				row.innerHTML = `<td>${tr.desc}</td><td>$${tr.amount.toFixed(2)}</td><td>${tr.type}</td>`;
				transactionsTbody.appendChild(row);
				if (tr.type === 'income') totalIncome += tr.amount;
				else totalExpense += tr.amount;
			});
			totalIncomeEl.textContent = totalIncome.toFixed(2);
			totalExpenseEl.textContent = totalExpense.toFixed(2);
			balanceEl.textContent = (totalIncome - totalExpense).toFixed(2);
		}
	</script>
</body>
</html>
