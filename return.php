<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $bookId = $_POST['book_id'];

    // Update book quantity
    $updateQuantityQuery = "UPDATE books SET available_quantity = available_quantity + 1 WHERE id = $bookId";
    mysqli_query($conn, $updateQuantityQuery);

    // Update borrow record
    $updateRecordQuery = "UPDATE borrow_records SET returned = 1 WHERE user_id = $userId AND book_id = $bookId AND returned = 0";
    mysqli_query($conn, $updateRecordQuery);

    header("Location: student_dashboard.php");
}
?>
