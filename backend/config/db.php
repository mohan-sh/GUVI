<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "mohan";     // Replace with your MySQL password
$dbname = "guvi_project"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error));
    exit();
}
?>
