<?php 
require_once dirname(__DIR__) . '/includes/functions.php';

// Redirect if not logged in
if (!is_logged_in()) {
    header('Location: /public/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration_id = (int)($_POST['registration_id'] ?? 0);
    
    if ($registration_id) {
        $result = cancel_user_registration($registration_id);
        if ($result['success']) {
            header('Location: /public/dashboard.php?cancelled=1');
            exit;
        } else {
            header('Location: /public/dashboard.php?error=' . urlencode($result['error']));
            exit;
        }
    }
}

header('Location: /public/dashboard.php');
exit;
?>
