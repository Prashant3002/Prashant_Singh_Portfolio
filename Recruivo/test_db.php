<?php
include('backend/db/db_connection.php');

// Test Query
$query = "SELECT DATABASE() AS db_name";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo "Connected to Database: " . $row['db_name'];
} else {
    echo "Query failed.";
}

$conn->close();
?>
