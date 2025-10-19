<?php 
require_once dirname(__DIR__) . '/includes/functions.php';

// Redirect if not logged in
if (!is_logged_in()) {
    header('Location: /public/login.php');
    exit;
}

$pageTitle = 'My Marathons — Eventify'; 
include dirname(__DIR__) . '/includes/header.php'; 

$user = get_logged_in_user();
$user_registrations = get_user_registrations();
$all_events = load_events();

$message = '';
$error = '';

// Handle success/error messages from registration
if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $bib = $_GET['bib'] ?? '';
    $message = 'Successfully registered for the marathon!' . ($bib ? ' Your bib number is #' . $bib . '.' : '');
    $user_registrations = get_user_registrations(); // Refresh
}
if (isset($_GET['cancelled']) && $_GET['cancelled'] == '1') {
    $message = 'Registration cancelled successfully!';
    $user_registrations = get_user_registrations(); // Refresh
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

// Get registered event IDs for current user
$registered_event_ids = array_column($user_registrations, 'event_id');
?>

<section class="section">
  <div class="container">
    <h2>My Marathons</h2>
    
    <?php if ($message): ?>
        <div style="color: #22d3ee; background: #1f2937; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
            <?php echo h($message); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div style="color: #ef4444; background: #1f2937; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
            <?php echo h($error); ?>
        </div>
    <?php endif; ?>
    
    <!-- My Registered Marathons -->
    <div class="mt-4">
        <h3>My Registered Marathons</h3>
        <?php if (empty($user_registrations)): ?>
            <p>You haven't registered for any marathons yet.</p>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($user_registrations as $reg): ?>
                    <article class="card">
                        <img src="<?php echo h(strpos($reg['image'] ?? '', 'http') === 0 ? ($reg['image'] ?? 'https://images.unsplash.com/photo-1544915319-6ae69f0940f6?q=80&w=600&auto=format&fit=crop') : get_city_marathon_photo($reg['image'] ?? 'almaty')); ?>" alt="<?php echo h($reg['title']); ?>">
                        <div class="content">
                            <h3><?php echo h($reg['title']); ?></h3>
                            <div class="meta">
                                <span><?php echo h($reg['date']); ?></span>
                                <span><?php echo h($reg['event_distance']); ?></span>
                                <span><?php echo h($reg['location']); ?></span>
                                <span><?php echo h($reg['category'] ?? ''); ?></span>
                            </div>
                            <p><strong>Your Distance:</strong> <?php echo h($reg['distance']); ?></p>
                            <p><strong>Bib Number:</strong> #<?php echo h($reg['bib_number'] ?? 'TBD'); ?></p>
                            <p><strong>Start Time:</strong> <?php echo h($reg['start_time'] ?? 'TBD'); ?></p>
                            <p><strong>Status:</strong> <span style="color: #22d3ee;"><?php echo h($reg['status'] ?? 'registered'); ?></span></p>
                            <p><strong>Registered:</strong> <?php echo h($reg['created_at']); ?></p>
                            <div class="mt-3">
                                <form method="post" action="/public/cancel_registration.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to cancel this registration?');">
                                    <input type="hidden" name="registration_id" value="<?php echo (int)$reg['id']; ?>">
                                    <button type="submit" class="btn" style="background: #ef4444; color: white;">Cancel Registration</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Available Marathons -->
    <div class="mt-4">
        <h3>Available Marathons</h3>
        <div class="grid">
            <?php foreach ($all_events as $event): ?>
                <?php if (!in_array($event['id'], $registered_event_ids)): ?>
                    <article class="card">
                        <img src="<?php echo h(strpos($event['image'], 'http') === 0 ? $event['image'] : get_city_marathon_photo($event['image'])); ?>" alt="<?php echo h($event['title']); ?>">
                        <div class="content">
                            <h3><?php echo h($event['title']); ?></h3>
                            <div class="meta">
                                <span><?php echo h($event['date']); ?></span>
                                <span><?php echo h($event['distance']); ?></span>
                                <span><?php echo h($event['location']); ?></span>
                                <span><?php echo h($event['category'] ?? ''); ?></span>
                            </div>
                            <form method="post" action="/public/register_for_marathon.php" style="margin-top: 12px;">
                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                <div>
                                    <label for="distance_<?php echo $event['id']; ?>">Choose Distance</label>
                                    <select id="distance_<?php echo $event['id']; ?>" name="distance" required style="width: 100%; margin-top: 4px; padding: 8px; border-radius: 6px; background: #0b1224; border: 1px solid #1f2937; color: var(--text);">
                                        <option value="">Select Distance</option>
                                        <option value="10 км">10 км</option>
                                        <option value="21 км">21 км</option>
                                        <option value="42 км">42 км</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn" style="margin-top: 8px;">Register for Marathon</button>
                            </form>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
