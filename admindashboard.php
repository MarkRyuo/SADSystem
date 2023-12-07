<?php
session_start();
require_once 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
}

// Fetch borrow book list
$query = "SELECT * FROM borrow_records WHERE returned = 0";
$result = mysqli_query($conn, $query);
$borrowedBooks = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch returned book list
$query = "SELECT * FROM borrow_records WHERE returned = 1";
$result = mysqli_query($conn, $query);
$returnedBooks = mysqli_fetch_all($result, MYSQLI_ASSOC);

include 'admindashboard.html';
?>