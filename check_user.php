<?php
require 'db.php';

$email = 'admin@gmail.com';
$password = 'admin123';

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo "<pre>";

if (!$user) {
    echo "User not found in database.";
    exit;
}

echo "User found:\n";
print_r($user);

echo "\nPassword verify result:\n";
var_dump(password_verify($password, $user['password']));

echo "</pre>";