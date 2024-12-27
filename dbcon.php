<?php
// Database credentials
$host = 'localhost';      // Server name (use '127.0.0.1' if 'localhost' doesn't work)
$username = 'root';       // Database username
$password = '';           // Database password (default is empty for XAMPP)
$dbname = 'crud'; // Name of the database

// Establishing connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully!";
?>
