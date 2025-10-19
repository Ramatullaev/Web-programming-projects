<?php 
require_once dirname(__DIR__) . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = (int)($_POST['event_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $distance = trim($_POST['distance'] ?? '');

    if ($eventId && $name && $email && $phone && $distance) {
        add_registration([
            'event_id' => $eventId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'distance' => $distance,
        ]);
        header('Location: /public/register_success.php?name=' . urlencode($name));
        exit;
    }
}
header('Location: /public/register.php');


