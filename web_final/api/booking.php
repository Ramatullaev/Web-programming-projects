<?php
// Web Service v2 (POST) - Accepts booking data, updates database, returns confirmation
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    // Validate required fields
    $required = ['client_name', 'client_email', 'service_type', 'event_date'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Field '$field' is required");
        }
    }
    
    // Sanitize and validate input
    $client_name = sanitizeInput($data['client_name']);
    $client_email = sanitizeInput($data['client_email']);
    
    if (!validateEmail($client_email)) {
        throw new Exception('Invalid email address');
    }
    
    $client_phone = isset($data['client_phone']) ? sanitizeInput($data['client_phone']) : '';
    $service_type = sanitizeInput($data['service_type']);
    $event_date = sanitizeInput($data['event_date']);
    $event_time = isset($data['event_time']) ? sanitizeInput($data['event_time']) : null;
    $message = isset($data['message']) ? sanitizeInput($data['message']) : '';
    
    // Validate date format
    $dateObj = DateTime::createFromFormat('Y-m-d', $event_date);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $event_date) {
        throw new Exception('Invalid date format');
    }
    
    // Check if date is in the future
    $today = new DateTime();
    if ($dateObj < $today) {
        throw new Exception('Event date must be in the future');
    }
    
    // Insert into database
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO bookings (client_name, client_email, client_phone, service_type, event_date, event_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    if (!$stmt) {
        throw new Exception('Database preparation failed: ' . $conn->error);
    }
    
    $stmt->bind_param("sssssss", $client_name, $client_email, $client_phone, $service_type, $event_date, $event_time, $message);
    
    if ($stmt->execute()) {
        $bookingId = $conn->insert_id;
        $stmt->close();
        $conn->close();
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking submitted successfully! We will contact you soon.',
            'booking_id' => $bookingId
        ]);
    } else {
        throw new Exception('Failed to insert booking: ' . $stmt->error);
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>

