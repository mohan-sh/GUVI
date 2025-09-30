<?php

try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
} catch (RedisException $e) {
    http_response_code(500);
    echo json_encode(array("status" => "error", "message" => "Redis connection failed: " . $e->getMessage()));
    exit();
}
?>
