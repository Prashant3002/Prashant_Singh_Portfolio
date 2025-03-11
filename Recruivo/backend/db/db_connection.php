<?php
// Database Configuration
$host = 'localhost';          // Database host (default is localhost)
$username = 'root';           // Database username
$password = '';               // Database password
$database = 'recruivo';       // Database name

// Create Connection
$conn = new mysqli($host, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    // Log error to a file for debugging (optional)
    error_log("Database Connection Failed: " . $conn->connect_error);
    
    // Display a generic error message to the user
    die("Connection to the database failed. Please try again later.");
}

// Connection Successful
// Use this connection ($conn) for executing queries
?>
