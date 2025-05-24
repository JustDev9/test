<?php
require_once 'config.php';
require_once 'EmailHelper.php';
header('Content-Type: application/json');

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

// Handle POST request for new application
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents('php://input');
    $applicationData = json_decode($requestBody, true);

    if (!$applicationData) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request data']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO adoption_applications
            (pet_id, full_name, email, phone, address, appointment_date, appointment_time, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $applicationData['petId'],
            $applicationData['fullName'],
            $applicationData['email'],
            $applicationData['phone'],
            $applicationData['address'],
            $applicationData['appointmentDate'],
            $applicationData['appointmentTime'],
            $applicationData['notes'] ?? null
        ]);

        $applicationId = $pdo->lastInsertId();

        // Update pet status to 'On Hold'
        $updatePetStmt = $pdo->prepare("
            UPDATE pets
            SET status = 'On Hold'
            WHERE id = ?
        ");
        $updatePetStmt->execute([$applicationData['petId']]);

        // Get pet details for email
        $petStmt = $pdo->prepare("SELECT name FROM pets WHERE id = ?");
        $petStmt->execute([$applicationData['petId']]);
        $pet = $petStmt->fetch(PDO::FETCH_ASSOC);

        // Prepare application data for email
        $emailData = [
            'full_name' => $applicationData['fullName'],
            'email' => $applicationData['email'],
            'pet_name' => $pet['name'],
            'appointment_date' => $applicationData['appointmentDate'],
            'appointment_time' => $applicationData['appointmentTime']
        ];

        // Send confirmation email
        $emailHelper = new EmailHelper($config);
        $emailHelper->sendApplicationConfirmation($emailData);

        echo json_encode([
            'success' => true,
            'applicationId' => $applicationId,
            'message' => 'Application submitted successfully'
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to save application',
            'message' => $e->getMessage()
        ]);
    }
}

// Handle GET request to fetch applications
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("
            SELECT a.*, p.name as pet_name, p.photo as pet_photo
            FROM adoption_applications a
            JOIN pets p ON a.pet_id = p.id
            ORDER BY a.created_at DESC
        ");

        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($applications);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to fetch applications',
            'message' => $e->getMessage()
        ]);
    }
}

// Handle PUT request to update application status
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $requestBody = file_get_contents('php://input');
    $updateData = json_decode($requestBody, true);

    if (!$updateData || !isset($updateData['id']) || !isset($updateData['status'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request data']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE adoption_applications
            SET status = ?
            WHERE id = ?
        ");

        $stmt->execute([$updateData['status'], $updateData['id']]);

        // If application is approved, update pet status to 'Adopted'
        if ($updateData['status'] === 'Approved') {
            $updatePetStmt = $pdo->prepare("
                UPDATE pets
                SET status = 'Adopted'
                WHERE id = (SELECT pet_id FROM adoption_applications WHERE id = ?)
            ");
            $updatePetStmt->execute([$updateData['id']]);
        }

        // Get application details for email
        $appStmt = $pdo->prepare("
            SELECT a.*, p.name as pet_name
            FROM adoption_applications a
            JOIN pets p ON a.pet_id = p.id
            WHERE a.id = ?
        ");
        $appStmt->execute([$updateData['id']]);
        $application = $appStmt->fetch(PDO::FETCH_ASSOC);

        // Send status update email
        $emailHelper = new EmailHelper($config);
        $emailHelper->sendApplicationStatusUpdate($application);

        echo json_encode([
            'success' => true,
            'message' => 'Application status updated successfully'
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to update application status',
            'message' => $e->getMessage()
        ]);
    }
}