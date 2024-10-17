<?php
// Database connection settings
$servername = "localhost";  // Change if your database server is remote
$username = "root";         // MySQL username
$password = "";             // MySQL password
$dbname = "login_db";       // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from login page
$email = $_POST['email'];
$pass = $_POST['pass'];

// Protect against SQL injection
$email = $conn->real_escape_string($email);
$pass = $conn->real_escape_string($pass);

// Query the database for the user
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user record
    $row = $result->fetch_assoc();
    
    // Verify the password (assuming password is hashed)
    if (password_verify($pass, $row['password'])) {
        // Login successful
        echo "Login successful! Welcome, " . $row['name'];
        // Redirect or create session logic, e.g., header('Location: dashboard.php');
    } else {
        // Invalid password
        echo "Invalid email or password.";
    }
} else {
    // No user found with this email
    echo "Invalid email or password.";
}

// Close connection
$conn->close();
?>
