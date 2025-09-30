<?php

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isEmailRegistered($conn, $email) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}

function generateSessionToken() {
    return bin2hex(random_bytes(32));
}

function validateSession($redis, $sessionToken, &$userId) {
    $userId = $redis->get($sessionToken);
    if ($userId) {
        $redis->expire($sessionToken, 3600); // Renew session for 1 hour
        return true;
    }
    return false;
}

function getUserIdFromSession($redis, $sessionToken) {
    return $redis->get($sessionToken);
}

?>
