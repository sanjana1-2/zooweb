<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo_database"; // Corrected: Added missing closing quotation mark

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $membershipType = htmlspecialchars($_POST['membershipType']);
    $additionalInfo = isset($_POST['additionalInfo']) ? htmlspecialchars($_POST['additionalInfo']) : '';

    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+1 year'));
    $status = 'active';

    $stmt = $conn->prepare("INSERT INTO Membership (name, email, membershipType, startDate, endDate, status, additionalInfo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $membershipType, $startDate, $endDate, $status, $additionalInfo);

    if ($stmt->execute()) {
        echo "<div style='padding: 20px; background: #d4edda; color: #155724;'>
                <strong>Success!</strong> Your membership has been created successfully. You can now enjoy all the benefits of being a member. 🎉
              </div>";
    } else {
        echo "<div style='padding: 20px; background: #f8d7da; color: #721c24;'>
                <strong>Error!</strong> There was an issue processing your membership. Please try again later or contact support. Error details: " . htmlspecialchars($stmt->error) . "
              </div>";
    }

    $stmt->close();
}

$conn->close();
?>
