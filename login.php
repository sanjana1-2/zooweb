<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0;'>Login successful!</div>";
    } else {
        echo "Invalid username or password.";
    }
}

$conn->close();
?>