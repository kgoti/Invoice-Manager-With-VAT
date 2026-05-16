<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    'SELECT i.*, c.name AS client_name, c.email AS client_email, c.address AS client_address
     FROM invoices i
     JOIN clients c ON c.id = i.client_id
     WHERE i.id = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$inv = $stmt->get_result()->fetch_assoc();

if (!$inv) {
    header('Location: invoices.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?php echo $inv['invoice_number']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="max-width: 600px;">

    <div class="top-bar">
        <h2>Invoice Details</h2>
        <a href="invoices.php">← Back</a>
    </div>

    <div class="invoice-box">

        <p><strong>Invoice #:</strong> <?php echo htmlspecialchars($inv['invoice_number']); ?></p>
        <p><strong>Date:</strong> <?php echo $inv['created_at']; ?></p>
        <p><strong>Due Date:</strong> <?php echo $inv['due_date']; ?></p>

        <hr>

        <p><strong>Client:</strong> <?php echo htmlspecialchars($inv['client_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($inv['client_email']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($inv['client_address']); ?></p>

        <hr>

        <p><strong>Netto:</strong> €<?php echo number_format($inv['amount_netto'], 2); ?></p>
        <p><strong>MwSt (<?php echo $inv['vat_rate']; ?>%):</strong> €<?php echo number_format($inv['vat_amount'], 2); ?></p>
        <p><strong>Brutto:</strong> €<?php echo number_format($inv['amount_brutto'], 2); ?></p>

        <hr>

        <p>
            <strong>Status:</strong>
            <span class="status <?php echo $inv['status']; ?>">
                <?php echo ucfirst($inv['status']); ?>
            </span>
        </p>

    </div>

</div>

</body>
</html>