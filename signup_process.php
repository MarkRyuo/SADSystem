<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if the username is already taken
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            // Display an alert on successful registration
            echo '<script>alert("Registered successfully. You can now log in.");';
            echo 'window.location.href = "index.html";</script>';
            // Redirect the user to the login page
        } else {
            echo "Error in registration. Please try again.";
        }
    }
}
?>

