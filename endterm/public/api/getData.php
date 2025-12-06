<?php
// getData.php - Web Service v1 (GET)
// Returns data from JSON files based on type parameter

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once dirname(__DIR__, 2) . '/includes/functions.php';

$type = $_GET['type'] ?? '';

if ($type === 'events') {
    $events = load_events();
    echo json_encode([
        'success' => true,
        'type' => 'events',
        'count' => count($events),
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $events
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} elseif ($type === 'registrations') {
    $registrations = load_registrations();
    echo json_encode([
        'success' => true,
        'type' => 'registrations',
        'count' => count($registrations),
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $registrations
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} elseif ($type === 'featured') {
    // Get next 3 upcoming events
    $events = load_events();
    $featured = array_slice($events, 0, 3);
    echo json_encode([
        'success' => true,
        'type' => 'featured',
        'count' => count($featured),
        'timestamp' => date('Y-m-d H:i:s'),
        'data' => $featured
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid type parameter. Use ?type=events, ?type=registrations, or ?type=featured'
    ], JSON_UNESCAPED_UNICODE);
}
?>
