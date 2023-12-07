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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2, h3 {
            color: #333;
        }

        nav {
            background-color: #007BFF;
            padding: 10px;
            text-align: right;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #0056b3;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .logout-link {
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        <a href="/index.html">Logout</a>
    </nav>

    <div class="container">
        <h2>Welcome, Admin!</h2>

        <h3>Borrowed Books</h3>
        <table>
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
        <table>
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
    </div>

    <!-- <a href="/index.html" class="logout-link">Logout</a> -->
</body>
</html>
