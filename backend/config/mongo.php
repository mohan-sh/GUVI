<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Adjust path if necessary

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDb = $mongoClient->guvi_project; // Replace with your MongoDB database name
    $mongoCollection = $mongoDb->profiles;
} catch (MongoDB\Driver\Exception\Exception $e) {
    http_response_code(500);
    echo json_encode(array("status" => "error", "message" => "MongoDB connection failed: " . $e->getMessage()));
    exit();
}
?>
