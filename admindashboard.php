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
            margin: 0; /* Set margin to 0 to remove the space at the top */
        }

        h2, h3 {
            color: #333;
        }

        nav {
            background-color: #fff;
            /* border: 1px solid black; */
            box-shadow: 2px 2px 5px #ddd;
            height: 9vh;
            display: flex;
            align-items: center;
            justify-content: space-between;

        }

        nav a {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-decoration: none;
            margin-top: 2vh;
            margin-right: 10vw;
            border-radius: 5px;
            background-color: #007BFF;
            height: 5vh;
            width: 6vw;
            margin-bottom: 2vh;
        }

        nav h1 {
            margin-left: 10vw;
        }

        nav a:hover {
            background-color: #0056b3;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: space-evenly;

            box-shadow: 2px 2px 4px #ddd;

            height: 50vh;
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
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Welcome, Admin!</h1>
        <a href="/index.html">Logout</a>
    </nav>

    <div class="container">
        

        <h3>Student's Borrowed Books</h3>
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

        <h3>Student's Returned Books</h3>
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
