
<?php
require '../../config.php';
require '../../session.php';
date_default_timezone_set('Asia/Kolkata');
ini_set('error_log', 'error.log');


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get POST data
$currentPassword = $_POST['currentPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validate input
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if ($newPassword !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'New passwords do not match']);
    exit;
}

// Password strength validation
// if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*()_+\-=\[\]{};:\'",.<>/?]{8,}$/', $newPassword)) {
//     echo json_encode(['success' => false, 'message' => 'Password does not meet requirements']);
//     exit;
// }

try {
    // Assuming config.php has established the database connection in $db variable
    
    // First verify current password
    $stmt = $db->prepare("SELECT pass FROM ofaculty WHERE pass = ?");
    $stmt->bind_param("s", $currentPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
        exit;
    }

    // Update password
    $stmt = $db->prepare("UPDATE ofaculty SET pass = ? WHERE pass = ?");
    $stmt->bind_param("ss", $newPassword, $currentPassword);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update password']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($db)) {
        $db->close();
    }
}