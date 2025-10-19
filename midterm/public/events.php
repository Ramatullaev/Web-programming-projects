<?php $pageTitle = 'Events — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>
<?php 
$events = load_events();

$date = $_GET['date'] ?? '';
$category = $_GET['category'] ?? '';

if ($date) {
    $events = array_values(array_filter($events, function($e) use ($date) {
        return strpos($e['date'], $date) === 0; // supports YYYY or YYYY-MM or exact
    }));
}
if ($category) {
    $events = array_values(array_filter($events, function($e) use ($category) {
        return strcasecmp($e['category'] ?? '', $category) === 0;
    }));
}

$categories = array_values(array_unique(array_map(function($e){ return $e['category'] ?? ''; }, load_events())));
?>

<section class="section">
  <div class="container">
    <h2>All Events</h2>
    <form class="mt-3" method="get">
      <div class="grid" style="grid-template-columns: repeat(4, 1fr); gap: 12px;">
        <div>
          <label for="date">Date (YYYY or YYYY-MM)</label>
          <input id="date" name="date" placeholder="2025-06" value="<?php echo h($date); ?>">
        </div>
        <div>
          <label for="category">Category</label>
          <select id="category" name="category">
            <option value="">All</option>
            <?php foreach ($categories as $c): if (!$c) continue; ?>
              <option value="<?php echo h($c); ?>" <?php echo ($category===$c? 'selected' : ''); ?>><?php echo h($c); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="flex space-between" style="align-items: end;">
          <button type="submit">Filter</button>
          <a class="btn" href="/public/events.php">Reset</a>
        </div>
      </div>
    </form>

    <div class="grid mt-4">
      <?php if (empty($events)): ?>
        <p>No events found.</p>
      <?php else: foreach ($events as $e): ?>
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
            <div class="mt-3">
              <?php if (is_logged_in()): ?>
                <form method="post" action="/public/register_for_marathon.php" style="display: inline;">
                  <input type="hidden" name="event_id" value="<?php echo (int)$e['id']; ?>">
                  <select name="distance" required style="margin-right: 8px; padding: 8px; border-radius: 6px; background: #0b1224; border: 1px solid #1f2937; color: var(--text);">
                    <option value="">Choose Distance</option>
                    <option value="10 км">10 км</option>
                    <option value="21 км">21 км</option>
                    <option value="42 км">42 км</option>
                  </select>
                  <button type="submit" class="btn">Register for Marathon</button>
                </form>
              <?php else: ?>
                <a class="btn" href="/public/login.php">Login to Register</a>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; endif; ?>
    </div>
  </div>
 </section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


