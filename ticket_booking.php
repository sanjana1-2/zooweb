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
    $name = $_POST['name'];
    $date = $_POST['date'];
    $tickets = $_POST['tickets'];

    $sql = "INSERT INTO bookings (name, date, tickets) VALUES ('$name', '$date', '$tickets')";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0;'>Ticket booking successful!</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>