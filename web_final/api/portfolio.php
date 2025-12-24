<?php
// Web Service v1 (GET) - Returns portfolio items in JSON format
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../includes/config.php';

try {
    $conn = getDBConnection();
    
    // Get all portfolio items
    $sql = "SELECT id, title, category, description, image_url, created_at, featured FROM portfolio_items ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    $items = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert featured boolean to proper format
            $row['featured'] = (bool)$row['featured'];
            $items[] = $row;
        }
    }
    
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'data' => $items,
        'count' => count($items)
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch portfolio items',
        'message' => $e->getMessage()
    ]);
}
?>

