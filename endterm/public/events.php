<?php $pageTitle = 'Events — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>
<?php 
// Check if viewing single event detail
$event_id = (int)($_GET['id'] ?? 0);
if ($event_id) {
    $event = get_event_by_id($event_id);
    if ($event) {
        $pageTitle = h($event['title']) . ' — Eventify';
        // Show event detail view
?>
<section class="section">
  <div class="container">
    <a href="/public/events.php" style="margin-bottom: 20px; display: inline-block;">← Back to Events</a>
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
          <?php if (is_logged_in()): ?>
            <form method="post" action="/public/register_for_marathon.php" style="display: inline;">
              <input type="hidden" name="event_id" value="<?php echo (int)$event['id']; ?>">
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
    </div>
  </div>
</section>
<?php
        include dirname(__DIR__) . '/includes/footer.php';
        exit;
    }
}

// Show events list
$events = load_events();
$date = $_GET['date'] ?? '';
$category = $_GET['category'] ?? '';

if ($date) {
    $events = array_values(array_filter($events, function($e) use ($date) {
        return strpos($e['date'], $date) === 0;
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
    
    <!-- Interactive Components for Endterm -->
    <div style="display: flex; gap: 20px; align-items: center; margin: 20px 0; padding: 20px; background: #1f2937; border-radius: 10px; flex-wrap: wrap;">
      <!-- Bigger Pimpin' Button -->
      <button id="bigger-button" class="btn" style="cursor: pointer;">Bigger Pimpin' Button</button>
      
      <!-- Snoopy Bling Checkbox -->
      <label style="display: flex; align-items: center; gap: 8px; color: var(--text); cursor: pointer;">
        <input type="checkbox" id="snoopy-bling" style="width: 20px; height: 20px; cursor: pointer;">
        <span>✨ Snoopy Bling Mode</span>
      </label>
      
      <!-- Live Search -->
      <div style="flex: 1; min-width: 200px;">
        <input type="text" id="live-search" placeholder="🔍 Live search events (press 'S' to focus)" 
               style="width: 100%; padding: 10px; border-radius: 6px; background: #0b1224; border: 1px solid #1f2937; color: var(--text);">
      </div>
    </div>
    
    <div id="message-container"></div>
    
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

    <div class="grid mt-4" id="events-grid">
      <?php if (empty($events)): ?>
        <p>No events found.</p>
      <?php else: foreach ($events as $e): ?>
        <article class="card" data-event-title="<?php echo h(strtolower($e['title'])); ?>" data-event-location="<?php echo h(strtolower($e['location'])); ?>">
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
              <a class="btn" href="/public/events.php?id=<?php echo (int)$e['id']; ?>" style="margin-right: 8px;">View Details</a>
              <?php if (is_logged_in()): ?>
                <form method="post" action="/public/register_for_marathon.php" style="display: inline;">
                  <input type="hidden" name="event_id" value="<?php echo (int)$e['id']; ?>">
                  <select name="distance" required style="margin-right: 8px; padding: 8px; border-radius: 6px; background: #0b1224; border: 1px solid #1f2937; color: var(--text);">
                    <option value="">Choose Distance</option>
                    <option value="10 км">10 км</option>
                    <option value="21 км">21 км</option>
                    <option value="42 км">42 км</option>
                  </select>
                  <button type="submit" class="btn">Register</button>
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

<script>
// Enhanced live search with fade effects
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('live-search');
  const cards = document.querySelectorAll('.card');
  
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase().trim();
      
      cards.forEach(card => {
        const title = card.getAttribute('data-event-title') || '';
        const location = card.getAttribute('data-event-location') || '';
        const text = (title + ' ' + location).toLowerCase();
        
        if (text.includes(searchTerm)) {
          card.style.display = '';
          card.style.opacity = '1';
          card.style.transform = 'scale(1)';
          fadeIn(card);
        } else if (searchTerm) {
          card.style.opacity = '0.3';
          card.style.transform = 'scale(0.95)';
        } else {
          card.style.opacity = '1';
          card.style.transform = 'scale(1)';
        }
        card.style.transition = 'all 0.3s';
      });
    });
  }
  
  // Load events dynamically using fetch API (demonstration)
  const loadEventsButton = document.createElement('button');
  loadEventsButton.textContent = '🔄 Refresh Events (Fetch API Demo)';
  loadEventsButton.className = 'btn';
  loadEventsButton.style.marginTop = '20px';
  loadEventsButton.addEventListener('click', async () => {
    const container = document.getElementById('message-container');
    showMessage(container, 'Loading events...', 'info');
    
    try {
      const events = await fetchEvents();
      showMessage(container, `Loaded ${events.length} events successfully!`, 'success');
    } catch (error) {
      showMessage(container, 'Error loading events', 'error');
    }
  });
  
  const form = document.querySelector('form');
  if (form && form.parentNode) {
    form.parentNode.insertBefore(loadEventsButton, form.nextSibling);
  }
});
</script>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


