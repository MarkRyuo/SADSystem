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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>

    <h3>Borrowed Books</h3>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Book ID</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
        </tr>
        <?php foreach ($borrowedBooks as $book): ?>
            <tr>
                <td><?= $book['user_id'] ?></td>
                <td><?= $book['book_id'] ?></td>
                <td><?= $book['borrow_date'] ?></td>
                <td><?= $book['return_date'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Returned Books</h3>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Book ID</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
        </tr>
        <?php foreach ($returnedBooks as $book): ?>
            <tr>
                <td><?= $book['user_id'] ?></td>
                <td><?= $book['book_id'] ?></td>
                <td><?= $book['borrow_date'] ?></td>
                <td><?= $book['return_date'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="/index.html">Logout</a>
</body>
</html>
