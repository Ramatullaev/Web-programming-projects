<?php 
require_once dirname(__DIR__) . '/includes/functions.php';

// Redirect if not logged in
if (!is_logged_in()) {
    header('Location: /public/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = (int)($_POST['event_id'] ?? 0);
    $distance = trim($_POST['distance'] ?? '');
    
    if ($event_id && $distance) {
        $result = register_user_for_event($event_id, $distance);
        if ($result['success']) {
            $bib = $result['bib_number'] ?? '';
            header('Location: /public/dashboard.php?registered=1&bib=' . urlencode($bib));
            exit;
        } else {
            header('Location: /public/dashboard.php?error=' . urlencode($result['error']));
            exit;
        }
    }
}

header('Location: /public/events.php');
exit;
?>
