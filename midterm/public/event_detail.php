<?php 
$id = (int)($_GET['id'] ?? 0);
$event = get_event_by_id($id);
$pageTitle = $event ? (h($event['title']) . ' — Eventify') : 'Event not found';
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
  <div class="container">
    <?php if (!$event): ?>
      <p>Event not found.</p>
    <?php else: ?>
      <div class="card" style="overflow:hidden;">
        <img src="<?php echo h(strpos($event['image'], 'http') === 0 ? $event['image'] : get_city_marathon_photo($event['image'])); ?>" alt="<?php echo h($event['title']); ?>">
        <div class="content">
          <h2 style="margin:0 0 10px;"><?php echo h($event['title']); ?></h2>
          <div class="meta">
            <span><?php echo h($event['date']); ?></span>
            <span><?php echo h($event['distance']); ?></span>
            <span><?php echo h($event['location']); ?></span>
            <span><?php echo h($event['category'] ?? ''); ?></span>
          </div>
          <div class="mt-4">
            <a class="btn" href="/public/register.php?id=<?php echo (int)$event['id']; ?>">Buy Ticket</a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


