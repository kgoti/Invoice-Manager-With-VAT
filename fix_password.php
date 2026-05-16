<?php
require 'db.php';

$email = 'admin@gmail.com';
$hash = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hash, $email);

if ($stmt->execute()) {
    echo "Password updated successfully.<br>";
    echo $hash;
} else {
    echo "Error: " . $conn->error;
}
?>