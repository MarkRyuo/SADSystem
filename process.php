<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Borrow Book
if (isset($_POST['borrow'])) {
    $book_id = $_POST['book_id'];
    $student_name = $_POST['student_name'];

    // Check if the book is available
    $check_query = "SELECT * FROM books WHERE book_id = $book_id AND available = TRUE";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Book is available, proceed with the transaction
        $borrow_date = date("Y-m-d");
        $insert_query = "INSERT INTO transactions (book_id, student_name, borrowed_date) VALUES ($book_id, '$student_name', '$borrow_date')";
        $conn->query($insert_query);

        // Update book availability status
        $update_query = "UPDATE books SET available = FALSE WHERE book_id = $book_id";
        $conn->query($update_query);

        echo "Book borrowed successfully!";
    } else {
        echo "Book not available for borrowing.";
    }
}

// Return Book
if (isset($_POST['return'])) {
    $transaction_id = $_POST['transaction_id'];

    // Check if the transaction exists
    $check_query = "SELECT * FROM transactions WHERE transaction_id = $transaction_id";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Transaction exists, proceed with returning the book
        $return_date = date("Y-m-d");
        $update_query = "UPDATE transactions SET returned_date = '$return_date' WHERE transaction_id = $transaction_id";
        $conn->query($update_query);

        // Update book availability status
        $transaction = $result->fetch_assoc();
        $update_query = "UPDATE books SET available = TRUE WHERE book_id = " . $transaction['book_id'];
        $conn->query($update_query);

        echo "Book returned successfully!";
    } else {
        echo "Invalid transaction ID.";
    }
}

// Close the database connection
$conn->close();
?>
