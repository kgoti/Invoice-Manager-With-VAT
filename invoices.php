<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle mark as paid
if (isset($_GET['mark_paid'])) {
    $id = (int)$_GET['mark_paid'];
    $conn->query("UPDATE invoices SET status = 'paid' WHERE id = $id");
    header('Location: invoices.php');
    exit;
}

$invoices = $conn->query(
    'SELECT i.*, c.name AS client_name
     FROM invoices i
     JOIN clients c ON c.id = i.client_id
     ORDER BY i.created_at DESC'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="top-bar">
        <h2>Invoices</h2>
        <div>
            <a href="add_invoice.php" class="btn">+ New Invoice</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Client</th>
                <th>Netto</th>
                <th>MwSt</th>
                <th>Brutto</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($inv = $invoices->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($inv['invoice_number']); ?></td>
                    <td><?php echo htmlspecialchars($inv['client_name']); ?></td>
                    <td>€<?php echo number_format($inv['amount_netto'], 2); ?></td>
                    <td>€<?php echo number_format($inv['vat_amount'], 2); ?> (<?php echo $inv['vat_rate']; ?>%)</td>
                    <td>€<?php echo number_format($inv['amount_brutto'], 2); ?></td>
                    <td><?php echo $inv['due_date']; ?></td>
                    <td>
                        <span class="status <?php echo $inv['status']; ?>">
                            <?php echo ucfirst($inv['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="view_invoice.php?id=<?php echo $inv['id']; ?>">View</a>
                        <?php if ($inv['status'] === 'unpaid'): ?>
                            <a href="invoices.php?mark_paid=<?php echo $inv['id']; ?>"
                               onclick="return confirm('Mark as paid?')">Mark Paid</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>