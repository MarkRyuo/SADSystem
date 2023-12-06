<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $bookId = $_POST['book_id'];
    $borrowDate = date("Y-m-d");
    $returnDate = date("Y-m-d", strtotime("+14 days"));

    // Check if the book is available
    $checkAvailabilityQuery = "SELECT * FROM books WHERE id = $bookId AND available_quantity > 0";
    $availabilityResult = mysqli_query($conn, $checkAvailabilityQuery);

    if ($availabilityResult && mysqli_num_rows($availabilityResult) > 0) {
        // Update book quantity
        $updateQuantityQuery = "UPDATE books SET available_quantity = available_quantity - 1 WHERE id = $bookId";
        mysqli_query($conn, $updateQuantityQuery);

        // Record the borrow
        $recordBorrowQuery = "INSERT INTO borrow_records (user_id, book_id, borrow_date, return_date) VALUES ($userId, $bookId, '$borrowDate', '$returnDate')";
        mysqli_query($conn, $recordBorrowQuery);

        header("Location: student_dashboard.php");
    } else {
        echo "Book not available for borrowing.";
    }
}
?>
