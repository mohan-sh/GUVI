<?php
require_once 'db.php';

if ($conn) {
    echo "MySQL connection successful!\n";
    // Optionally, try a simple query
    $result = $conn->query("SELECT 1+1 AS test");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Query result: " . $row['test'] . "\n";
    } else {
        echo "Simple query failed: " . $conn->error . "\n";
    }
    $conn->close();
} else {
    echo "MySQL connection failed.\n";
}
?>
