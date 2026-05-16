
<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Total invoices
$total_invoices = $conn->query('SELECT COUNT(*) AS total FROM invoices')->fetch_assoc();

// Paid invoices
$paid = $conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status = 'paid'")->fetch_assoc();

// Unpaid invoices
$unpaid = $conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status = 'unpaid'")->fetch_assoc();

// Total revenue (paid only)
$revenue = $conn->query("SELECT SUM(amount_brutto) AS total FROM invoices WHERE status = 'paid'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="top-bar">
        <h2>Dashboard</h2>
        <div>
            <a href="invoices.php">Invoices</a>
            <a href="clients.php">Clients</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="cards">

        <div class="card">
            <p>Total Invoices</p>
            <h3><?php echo $total_invoices['total']; ?></h3>
        </div>

        <div class="card">
            <p>Paid</p>
            <h3><?php echo $paid['total']; ?></h3>
        </div>

        <div class="card">
            <p>Unpaid</p>
            <h3><?php echo $unpaid['total']; ?></h3>
        </div>

        <div class="card">
            <p>Total Revenue</p>
            <h3>€<?php echo number_format($revenue['total'] ?? 0, 2); ?></h3>
        </div>

    </div>

</div>

</body>
</html>