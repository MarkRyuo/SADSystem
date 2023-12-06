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

  // Student Login
  if (isset($_POST['student_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check student login credentials in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = 'student'");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      // Student login successful
      header("Location: /StudentDashboard.html"); // Redirect to the student dashboard
      exit();
  } else {
      echo "Invalid Student ID or password.";
  } 
  }

  // Admin Login
  if (isset($_POST['admin_login'])) {
    $username_admin = $_POST['username_admin'];
    $password_admin = $_POST['password_admin'];

    // Check admin login credentials in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = 'admin'");
    $stmt->bind_param("ss", $username_admin, $password_admin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Admin login successful
        echo "Admin login successful!";
    } else {
        echo "Invalid admin username or password.";
    }
  }



// Close the database connection
$conn->close();
?>
