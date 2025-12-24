<?php
// Server-side form processing (backup/alternative method)
require_once 'includes/config.php';

$pageTitle = 'Тапсырыс растау - Қазақ Тағамдары';
require_once 'includes/header.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $client_name = isset($_POST['client_name']) ? sanitizeInput($_POST['client_name']) : '';
    $client_email = isset($_POST['client_email']) ? sanitizeInput($_POST['client_email']) : '';
    $client_phone = isset($_POST['client_phone']) ? sanitizeInput($_POST['client_phone']) : '';
    $service_type = isset($_POST['service_type']) ? sanitizeInput($_POST['service_type']) : '';
    $event_date = isset($_POST['event_date']) ? sanitizeInput($_POST['event_date']) : '';
    $event_time = isset($_POST['event_time']) ? sanitizeInput($_POST['event_time']) : '';
    $message_text = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';
    
    // Validation
    $errors = [];
    
    if (empty($client_name)) {
        $errors[] = 'Аты-жөні міндетті';
    }
    
    if (empty($client_email)) {
        $errors[] = 'Email мекенжайы міндетті';
    } elseif (!validateEmail($client_email)) {
        $errors[] = 'Email мекенжайы дұрыс емес';
    }
    
    if (empty($service_type)) {
        $errors[] = 'Тағам түрі міндетті';
    }
    
    if (empty($event_date)) {
        $errors[] = 'Күні міндетті';
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        try {
            $conn = getDBConnection();
            
            $stmt = $conn->prepare("INSERT INTO bookings (client_name, client_email, client_phone, service_type, event_date, event_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("sssssss", $client_name, $client_email, $client_phone, $service_type, $event_date, $event_time, $message_text);
            
            if ($stmt->execute()) {
                $message = 'Тапсырыс сәтті жіберілді! Біз сізбен жақын арада байланысамыз.';
                $messageType = 'success';
            } else {
                $message = 'Қате: ' . $stmt->error;
                $messageType = 'error';
            }
            
            $stmt->close();
            $conn->close();
            
        } catch (Exception $e) {
            $message = 'Қате пайда болды: ' . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = 'Келесі қателерді түзетіңіз: ' . implode(', ', $errors);
        $messageType = 'error';
    }
}
?>

<section>
    <h2 class="section-title">Тапсырыс Статусы</h2>
    <div class="booking-form-container">
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <p><a href="portfolio.php" class="btn">Тағамдарға оралу</a></p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

