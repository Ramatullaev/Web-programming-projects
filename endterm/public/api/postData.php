<?php
// postData.php - Web Service v2 (POST)
// Accepts form data via fetch() and updates JSON file

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once dirname(__DIR__, 2) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'error' => 'Only POST method allowed'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Get JSON data from request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON data'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $data['action'] ?? 'comment';

// Handle different actions
if ($action === 'comment') {
    // Add a comment/feedback entry
    $comments = load_json('comments.json');
    
    $newComment = [
        'id' => count($comments) + 1,
        'name' => $data['name'] ?? 'Anonymous',
        'email' => $data['email'] ?? '',
        'message' => $data['message'] ?? '',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $comments[] = $newComment;
    save_json('comments.json', $comments);
    
    echo json_encode([
        'success' => true,
        'message' => 'Comment saved successfully',
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $newComment
    ], JSON_UNESCAPED_UNICODE);
    
} elseif ($action === 'registration') {
    // Handle marathon registration (for logged-in users)
    // This is a simplified version - actual registration uses register_for_marathon.php
    echo json_encode([
        'success' => true,
        'message' => 'Registration endpoint - use /public/register_for_marathon.php for actual registration',
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
    
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid action. Use action=comment or action=registration'
    ], JSON_UNESCAPED_UNICODE);
}
?>
