<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$total_invoices = $conn->query('SELECT COUNT(*) AS total FROM invoices')->fetch_assoc();
$paid = $conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status = 'paid'")->fetch_assoc();
$unpaid = $conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status = 'unpaid'")->fetch_assoc();
$revenue = $conn->query("SELECT SUM(amount_brutto) AS total FROM invoices WHERE status = 'paid'")->fetch_assoc();
?>