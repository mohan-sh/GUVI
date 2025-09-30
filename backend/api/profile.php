<?php
header('Content-Type: application/json');

require_once '../config/db.php'; // For getting user name/email from MySQL
require_once '../config/mongo.php';
require_once '../config/redis.php';
require_once '../utils/helpers.php';

$sessionToken = $_REQUEST['session_token'] ?? '';
$userEmail = $_REQUEST['email'] ?? '';
$userId = null;

if (!validateSession($redis, $sessionToken, $userId)) {
    http_response_code(401);
    echo json_encode(array("status" => "error", "message" => "Invalid or expired session."));
    exit();
}

// Fetch user's basic info from MySQL (name, email) as it's registration data
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$mysqlUserData = $result->fetch_assoc();
$stmt->close();

if (!$mysqlUserData) {
    http_response_code(404);
    echo json_encode(array("status" => "error", "message" => "User not found in MySQL."));
    $conn->close();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch profile data from MongoDB
    $profileData = $mongoCollection->findOne(['user_id' => (int)$userId]);

    if ($profileData) {
        // Merge MySQL data with MongoDB profile data
        $responseData = array_merge($mysqlUserData, (array) $profileData);
        unset($responseData['_id']); // Don't send MongoDB internal ID to frontend
        echo json_encode(array("status" => "success", "data" => $responseData));
    } else {
        // If no profile data in MongoDB, return only MySQL data
        echo json_encode(array("status" => "success", "data" => $mysqlUserData));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = $_POST['age'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $contact = $_POST['contact'] ?? null;

    $updateData = [
        'user_id' => (int)$userId,
        'age' => (int)$age,
        'date_of_birth' => $dob ? new MongoDB\BSON\UTCDateTime(strtotime($dob) * 1000) : null,
        'contact' => $contact,
        'updated_at' => new MongoDB\BSON\UTCDateTime()
    ];

    // Remove null values from update data if not provided
    $updateData = array_filter($updateData, function($value) { return $value !== null; });

    $updateResult = $mongoCollection->updateOne(
        ['user_id' => (int)$userId],
        ['$set' => $updateData],
        ['upsert' => true]
    );

    if ($updateResult->isAcknowledged()) {
        echo json_encode(array("status" => "success", "message" => "Profile updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Failed to update profile."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}

$conn->close();
?>
