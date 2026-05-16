<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$clients = $conn->query('SELECT id, name FROM clients ORDER BY name');
$error   = '';

// Generate invoice number like 2026-001
$count  = $conn->query('SELECT COUNT(*) AS total FROM invoices')->fetch_assoc();
$inv_no = date('Y') . '-' . str_pad($count['total'] + 1, 3, '0', STR_PAD_LEFT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = (int)$_POST['client_id'];
    $netto     = (float)$_POST['amount_netto'];
    $vat_rate  = (int)$_POST['vat_rate'];
    $due_date  = $_POST['due_date'];
    $today     = date('Y-m-d');

    if ($client_id === 0 || $netto <= 0 || empty($due_date)) {
        $error = 'Please fill in all fields correctly.';
    } else {
        // VAT Calculation
        $vat_amount    = round($netto * ($vat_rate / 100), 2);
        $amount_brutto = round($netto + $vat_amount, 2);

        $stmt = $conn->prepare(
            'INSERT INTO invoices
                (client_id, invoice_number, amount_netto, vat_rate, vat_amount, amount_brutto, created_at, due_date)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'isididss',
            $client_id,
            $inv_no,
            $netto,
            $vat_rate,
            $vat_amount,
            $amount_brutto,
            $today,
            $due_date
        );
        $stmt->execute();

        header('Location: invoices.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Invoice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h2>New Invoice</h2>
    <p class="inv-number">Invoice #: <strong><?php echo $inv_no; ?></strong></p>

    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Client *</label>
        <select name="client_id">
            <option value="0">-- Select Client --</option>
            <?php while ($c = $clients->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo htmlspecialchars($c['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Amount Netto (€) *</label>
        <input type="number" name="amount_netto" step="0.01" min="0.01" placeholder="0.00">

        <label>VAT Rate *</label>
        <select name="vat_rate">
            <option value="19">19% (Standard)</option>
            <option value="7">7% (Ermäßigt)</option>
            <option value="0">0% (Steuerfrei)</option>
        </select>

        <label>Due Date *</label>
        <input type="date" name="due_date" value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>">

        <button type="submit">Create Invoice</button>
        <a href="invoices.php">Cancel</a>

    </form>
</div>

</body>
</html>