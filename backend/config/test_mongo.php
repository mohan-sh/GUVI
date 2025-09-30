<?php
require_once 'mongo.php';

if (isset($mongoClient) && $mongoClient) {
    try {
        // Ping the server to check connectivity
        $command = new MongoDB\Driver\Command(['ping' => 1]);
        $cursor = $mongoDb->command($command); // Corrected line
        $response = $cursor->toArray();

        if (!empty($response) && isset($response[0]->ok) && $response[0]->ok == 1) {
            echo "MongoDB connection successful!\n";
        } else {
            echo "MongoDB ping failed: " . json_encode($response) . "\n";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "MongoDB connection failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "MongoDB client not initialized.\n";
}
?>
