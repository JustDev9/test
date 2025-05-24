<?php
require_once 'cors.php';
require_once 'db.php';

header('Content-Type: application/json');

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Get database connection
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']}",
        $config['db_user'],
        $config['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle GET request to fetch pets
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $query = "SELECT * FROM pets WHERE status != 'Adopted' ORDER BY created_at DESC";
        $stmt = $pdo->query($query);
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'pets' => $pets
        ]);
    }

    // Handle POST request to add a new pet
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verify admin token
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        // Get user ID from token
        $stmt = $pdo->prepare("SELECT user_id FROM user_tokens WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token']);
            exit();
        }

        // Verify user is admin
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$result['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Only admins can add pets']);
            exit();
        }

        // Handle file upload
        $photo_path = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../public/uploads/pets/';

            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_extension, $allowed_extensions)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid file type. Only JPG, JPEG, PNG and GIF are allowed.']);
                exit();
            }

            $file_name = uniqid() . '.' . $file_extension;
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
                $photo_path = '/uploads/pets/' . $file_name;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to upload photo']);
                exit();
            }
        }

        // Get POST data
        $data = [
            'name' => $_POST['name'] ?? null,
            'type' => $_POST['type'] ?? null,
            'breed' => $_POST['breed'] ?? null,
            'age' => $_POST['age'] ?? null,
            'description' => $_POST['description'] ?? null,
            'status' => $_POST['status'] ?? 'Available',
            'photo' => $photo_path
        ];

        // Validate required fields
        $required_fields = ['name', 'type', 'breed', 'age', 'description'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "Missing required field: $field"]);
                exit();
            }
        }

        // Insert new pet
        $stmt = $pdo->prepare("
            INSERT INTO pets (
                name, type, breed, age, description, status, photo,
                created_at, updated_at
            ) VALUES (
                :name, :type, :breed, :age, :description, :status, :photo,
                NOW(), NOW()
            )
        ");

        $stmt->execute([
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':breed' => $data['breed'],
            ':age' => $data['age'],
            ':description' => $data['description'],
            ':status' => $data['status'],
            ':photo' => $data['photo']
        ]);

        $petId = $pdo->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => 'Pet added successfully',
            'pet_id' => $petId
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage()
    ]);
}
?>