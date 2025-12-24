<?php
// Theme preference API endpoint
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (isset($data['theme']) && in_array($data['theme'], ['dark', 'light'])) {
        setThemeCookie($data['theme']);
        $_SESSION['theme'] = $data['theme'];
        
        echo json_encode([
            'success' => true,
            'theme' => $data['theme']
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid theme value'
        ]);
    }
} else {
    // GET request - return current theme
    $theme = getTheme();
    echo json_encode([
        'success' => true,
        'theme' => $theme
    ]);
}
?>

