<?php
// Database connection settings
$servername = "localhost";  // Change this if your MySQL server is not local
$username = "root";         // Replace with your MySQL username
$password = "";             // Replace with your MySQL password
$dbname = "login_db";       // Replace with the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data from the login page
$email = $_GET['email'];
$password = $_GET['pass'];

// Protect from SQL injection
$email = $conn->real_escape_string($email);
$password = $conn->real_escape_string($password);

// Query the database to find the user
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user record
    $row = $result->fetch_assoc();
    
    // Verify password (assuming passwords are hashed)
    if (password_verify($password, $row['password'])) {
        // Success: User is authenticated
        echo "Login successful! Welcome, " . $row['name'];
        // Redirect to a dashboard or home page, etc.
        // header('Location: dashboard.php');
    } else {
        // Invalid password
        echo "Invalid email or password.";
    }
} else {
    // No user found with that email
    echo "Invalid email or password.";
}

$conn->close();
?>
