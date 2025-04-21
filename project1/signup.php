<?php
// filepath: c:\xampp1\htdocs\zoo\signup.php

session_start();

$servername = "localhost"; // Replace with your database server name if different
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "zoo";           // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header("Access-Control-Allow-Origin: *");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $number = $_POST["number"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match!');
                window.history.back();
              </script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to insert user data
    $stmt = $conn->prepare("INSERT INTO users (name, mobile, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $number, $username, $hashed_password);

    if ($stmt->execute()) {
        // Redirect to login page on successful signup
        header("Location: login.html");
        exit();
    } else {
        echo "<script>
                alert('Error: Could not register user. Please try again.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>