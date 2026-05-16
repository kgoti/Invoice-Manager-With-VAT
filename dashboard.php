<?php
session_start();
require 'db.php';

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