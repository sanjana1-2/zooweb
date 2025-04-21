<?php


$servername = "localhost"; 
$username = "root";       
$password = "";           
$dbname = "zoo";        


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php


session_start();
include 'db.php'; 
header("Access-Control-Allow-Origin: *");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];
    $password = $_POST["password"];

  
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user["password"])) {
            // Set session variable and redirect to home.html
            $_SESSION['username'] = $username;
            header("Location: index.html");
            exit();
        } else {
            // Invalid password
            echo "<script>
                    alert('Invalid username or password');
                    window.history.back();
                  </script>";
        }
    } else {
        
        echo "<script>
                alert('Invalid username or password');
                window.history.back();
              </script>";
    }
    $stmt->close();
}
$conn->close();
?>