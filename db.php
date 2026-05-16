<?php
$host = getenv("MYSQLHOST");
$port = getenv("MYSQLPORT");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE") ?: getenv("MYSQL_DATABASE");

if (!$host || !$port || !$user || !$database) {
    die("Missing database environment variables.");
}

$conn = mysqli_connect($host, $user, $password, $database, (int)$port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>