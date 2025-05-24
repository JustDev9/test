<?php
require_once 'config.php';
header('Content-Type: application/json');

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get database connection
try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Get user ID from token
function getUserIdFromToken($token) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT user_id
            FROM user_tokens
            WHERE token = ? AND expires_at > NOW()
        ");
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['user_id'] : null;
    } catch (Exception $e) {
        return null;
    }
}

// Get authorization header
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

if (!$token) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$userId = getUserIdFromToken($token);
if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid or expired token']);
    exit();
}

// Handle GET request to fetch profile data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get user profile
        $stmt = $pdo->prepare("
            SELECT id, name, email, avatar
            FROM users
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get adopted pets
        $stmt = $pdo->prepare("
            SELECT p.*, a.created_at as adoption_date
            FROM pets p
            JOIN adoption_applications a ON p.id = a.pet_id
            WHERE a.status = 'Approved' AND a.user_id = ?
        ");
        $stmt->execute([$userId]);
        $adoptedPets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get pending applications
        $stmt = $pdo->prepare("
            SELECT a.*, p.name as pet_name, p.photo as pet_photo
            FROM adoption_applications a
            JOIN pets p ON a.pet_id = p.id
            WHERE a.user_id = ? AND a.status = 'Pending'
        ");
        $stmt->execute([$userId]);
        $pendingApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get appointments
        $stmt = $pdo->prepare("
            SELECT a.*, p.name as pet_name
            FROM adoption_applications a
            JOIN pets p ON a.pet_id = p.id
            WHERE a.user_id = ?
            AND a.appointment_date >= CURDATE()
            ORDER BY a.appointment_date, a.appointment_time
        ");
        $stmt->execute([$userId]);
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'profile' => $profile,
            'adoptedPets' => $adoptedPets,
            'pendingApplications' => $pendingApplications,
            'appointments' => $appointments
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to fetch profile data',
            'message' => $e->getMessage()
        ]);
    }
}

// Handle PUT request to update profile
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $requestBody = file_get_contents('php://input');
    $updateData = json_decode($requestBody, true);

    if (!$updateData || !isset($updateData['name']) || !isset($updateData['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request data']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE users
            SET name = ?, email = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $updateData['name'],
            $updateData['email'],
            $userId
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to update profile',
            'message' => $e->getMessage()
        ]);
    }
}