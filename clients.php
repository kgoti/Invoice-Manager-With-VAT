<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$clients = $conn->query('SELECT * FROM clients ORDER BY name ASC');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="top-bar">
        <h2>Clients</h2>
        <div>
            <a href="add_client.php" class="btn">+ Add Client</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($client = $clients->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                    <td><?php echo htmlspecialchars($client['email']); ?></td>
                    <td><?php echo htmlspecialchars($client['address']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>