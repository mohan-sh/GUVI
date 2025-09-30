<?php
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../utils/helpers.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "All fields are required."));
        exit();
    }

    if (!isValidEmail($email)) {
        echo json_encode(array("status" => "error", "message" => "Invalid email format."));
        exit();
    }

    if (isEmailRegistered($conn, $email)) {
        echo json_encode(array("status" => "error", "message" => "Email already registered."));
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "User registered successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Registration failed: " . $stmt->error));
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
