<?php
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../config/redis.php';
require_once '../utils/helpers.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "Email and password are required."));
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $sessionToken = generateSessionToken();
            $redis->setex($sessionToken, 3600, $user['id']); // Store user ID with session token for 1 hour

            echo json_encode(array("status" => "success", "message" => "Login successful.", "session_token" => $sessionToken, "user_email" => $user['email']));
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid credentials."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid credentials."));
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
