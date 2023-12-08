<?php
session_start();
require_once 'db.php';

if ($_SESSION['role'] !== 'student') {
    header("Location: index.php");
}

// Fetch available books
$query = "SELECT * FROM books WHERE available_quantity > 0";
$result = mysqli_query($conn, $query);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        nav {
            background-color: #fff;
            /* border: 1px solid black; */
            box-shadow: 2px 2px 5px #ddd;
            height: 9vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100vw;
            height: 10vh;

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

        section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Welcome, Student!</h1>
        <a href="/index.html" onclick="confirmLogout()">Logout</a>
    </nav>

    <section>
        <h2>Available Books</h2>
        <form action="borrow.php" method="post">
            <label for="book_id">Select a Book:</label>
            <select name="book_id">
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book['id'] ?>"><?= $book['title'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Borrow">
        </form>

        <h3>Your Borrowed Books</h3>
        <table border="1">
        <tr>
            <th>Book ID</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Return</th>
        </tr>
        <?php
        $userId = $_SESSION['user_id'];
        $query = "SELECT * FROM borrow_records WHERE user_id = $userId AND returned = 0";
        $result = mysqli_query($conn, $query);
        $borrowedBooks = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>
        <?php foreach ($borrowedBooks as $book): ?>
            <tr>
                <td><?= $book['book_id'] ?></td>
                <td><?= $book['borrow_date'] ?></td>
                <td><?= $book['return_date'] ?></td>
                <td>
                    <form action="return.php" method="post">
                        <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                        <input type="submit" value="Return">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    </section>
</body>
</html>
