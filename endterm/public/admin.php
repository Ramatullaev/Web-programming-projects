<?php 
require_once dirname(__DIR__) . '/includes/functions.php';
$pageTitle = 'Admin — Eventify';

// Handle add/delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $title = trim($_POST['title'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $distance = trim($_POST['distance'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    if ($title && $date && $location && $distance) {
        add_event([
            'title' => $title,
            'date' => $date,
            'location' => $location,
            'distance' => $distance,
            'category' => $category,
            'image' => $image ?: 'https://picsum.photos/800/300?blur=2'
        ]);
        header('Location: /public/admin.php');
        exit;
    }
}
if (($_GET['action'] ?? '') === 'delete' && isset($_GET['id'])) {
    delete_event((int)$_GET['id']);
    header('Location: /public/admin.php');
    exit;
}

$events = load_events();
$registrations = load_registrations();
include dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
  <div class="container">
    <h2>Manage Events</h2>
    <form class="mt-3" method="post">
      <input type="hidden" name="action" value="add">
      <div class="grid" style="grid-template-columns: repeat(3, 1fr); gap: 12px;">
        <div>
          <label>Title</label>
          <input name="title" required>
        </div>
        <div>
          <label>Date</label>
          <input name="date" placeholder="YYYY-MM-DD" required>
        </div>
        <div>
          <label>Location</label>
          <input name="location" required>
        </div>
        <div>
          <label>Distance</label>
          <input name="distance" placeholder="10 км" required>
        </div>
        <div>
          <label>Category</label>
          <input name="category" placeholder="10K / Half Marathon / Marathon">
        </div>
        <div>
          <label>Image URL</label>
          <input name="image" placeholder="https://...">
        </div>
      </div>
      <div class="mt-3"><button type="submit">Add Event</button></div>
    </form>

    <div class="grid mt-4">
      <?php foreach ($events as $e): ?>
        <article class="card">
          <img src="<?php echo h(strpos($e['image'], 'http') === 0 ? $e['image'] : get_city_marathon_photo($e['image'])); ?>" alt="<?php echo h($e['title']); ?>">
          <div class="content">
            <h3><?php echo h($e['title']); ?></h3>
            <div class="meta">
              <span><?php echo h($e['date']); ?></span>
              <span><?php echo h($e['distance']); ?></span>
              <span><?php echo h($e['location']); ?></span>
              <span><?php echo h($e['category'] ?? ''); ?></span>
            </div>
            <div class="mt-3 flex space-between">
              <a class="btn" href="/public/events.php?id=<?php echo (int)$e['id']; ?>">View</a>
              <a class="btn" href="/public/admin.php?action=delete&id=<?php echo (int)$e['id']; ?>" onclick="return confirm('Delete this event?');">Delete</a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>Participants</h2>
    <div class="card">
      <div class="content">
        <?php if (empty($registrations)): ?>
          <p>No registrations yet.</p>
        <?php else: ?>
          <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 8px;">
            <strong>Name</strong>
            <strong>Email</strong>
            <strong>Event</strong>
            <strong>Date</strong>
            <?php foreach ($registrations as $r): $ev = get_event_by_id($r['event_id']); ?>
              <div><?php echo h($r['name']); ?></div>
              <div><?php echo h($r['email']); ?></div>
              <div><?php echo h($ev['title'] ?? ''); ?></div>
              <div><?php echo h($r['created_at']); ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


