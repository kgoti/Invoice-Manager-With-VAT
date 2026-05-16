<?php
require 'db.php';

$email = 'admin@gmail.com';
$password = 'admin123';

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

echo "<pre>";
var_dump($user);
var_dump(password_verify($password, $user['password'] ?? ''));
echo "</pre>";
?>