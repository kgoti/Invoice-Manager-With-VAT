<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $address = trim($_POST['address']);

    if (empty($name)) {
        $error = 'Client name is required.';
    } else {
        $stmt = $conn->prepare(
            'INSERT INTO clients (name, email, address) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('sss', $name, $email, $address);
        $stmt->execute();

        header('Location: clients.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Client</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">
    <h2>Add Client</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Name *</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

        <label>Address</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">

        <button type="submit">Save Client</button>
        <a href="clients.php">Cancel</a>
    </form>
</div>

</body>
</html>