<?php $pageTitle = 'Home — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>

<section class="hero" id="hero">
    <div class="container">
        <div class="parallax" style="background-image:url('<?php echo file_exists(dirname(__DIR__)."/assets/photos/hero.jpg") ? "/assets/photos/hero.jpg" : "https://images.unsplash.com/photo-1520975751121-c8d8c58dfb37?q=80&w=1600&auto=format&fit=crop"; ?>');"></div>
        <div class="overlay"></div>
        <h1>Run the City. Join Almaty Marathons.</h1>
        <p>Discover upcoming races, track distances from 10K to full marathon, and secure your bib in seconds. Train, compete, and celebrate with the city.</p>
        <a class="cta" href="/public/events.php">Browse Events</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="mt-2">Featured Events</h2>
        <div id="dynamic-message-container" style="margin: 10px 0;"></div>
        <div class="grid mt-3" id="featured-events">
            <?php foreach (array_slice(load_events(), 0, 3) as $e): ?>
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
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="section">
  <div class="container">
    <?php 
    // Find the next upcoming race
    $events = load_events();
    $now = time();
    $nextEvent = null;
    $nextEventDate = null;
    
    foreach ($events as $event) {
        $eventDate = strtotime($event['date']);
        if ($eventDate > $now) {
            if ($nextEventDate === null || $eventDate < $nextEventDate) {
                $nextEventDate = $eventDate;
                $nextEvent = $event;
            }
        }
    }
    ?>
    
    <?php if ($nextEvent): ?>
      <h2>Next Race Starts In</h2>
      <div class="countdown mt-3" id="countdown">
        <div class="counter"><div class="num" id="d">0</div><div class="label">Days</div></div>
        <div class="counter"><div class="num" id="h">0</div><div class="label">Hours</div></div>
        <div class="counter"><div class="num" id="m">0</div><div class="label">Minutes</div></div>
        <div class="counter"><div class="num" id="s">0</div><div class="label">Seconds</div></div>
      </div>
      <p class="mt-2" style="opacity:0.8;"><?php echo date('F j, Y', $nextEventDate); ?> — <?php echo h($nextEvent['title']); ?> in <?php echo h($nextEvent['location']); ?></p>
      
      <script>
        (function(){
          const targetDate = "<?php echo date('Y-m-d', $nextEventDate); ?>";
          const targetTime = "07:00:00"; // Default start time (7 AM)
          const target = new Date(targetDate + "T" + targetTime + "Z");

          function tick(){
            const now = new Date();
            const diff = Math.max(0, target - now);

            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            document.getElementById('d').textContent = d;
            document.getElementById('h').textContent = h;
            document.getElementById('m').textContent = m;
            document.getElementById('s').textContent = s;

            if (diff <= 0) {
              document.getElementById('countdown').innerHTML = "<h3>The race has started!</h3>";
              clearInterval(interval);
            }
          }

          tick();
          const interval = setInterval(tick, 1000);
        })();
      </script>
    <?php else: ?>
      <h2>Next Race</h2>
      <p>No upcoming races scheduled.</p>
    <?php endif; ?>
  </div>

  <script>
    // Parallax effect (moved outside to avoid conflicts)
    window.addEventListener('scroll', ()=>{
      const y = window.scrollY * 0.3; 
      const el = document.querySelector('#hero .parallax'); 
      if (el) el.style.transform = 'translateY(' + (y * -1) + 'px)';
    });
    
    // Dynamic DOM manipulation on page load
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('dynamic-message-container');
      const eventsGrid = document.getElementById('featured-events');
      const cards = document.querySelectorAll('.card');
      
      // 1. Create a welcome message dynamically with Scriptaculous effect
      const welcomeMsg = createElement('div', 'message message-success');
      welcomeMsg.id = 'welcome-msg';
      welcomeMsg.textContent = '🎉 Welcome! Explore our featured marathons below.';
      welcomeMsg.style.marginBottom = '16px';
      welcomeMsg.style.display = 'none';
      container.appendChild(welcomeMsg);
      
      // Use Scriptaculous if available, otherwise fallback
      if (typeof Effect !== 'undefined') {
        new Effect.Appear('welcome-msg', { duration: 0.8 });
      } else {
        fadeIn(welcomeMsg);
      }
      
      // 2. Dynamically add pulsate effect to CTA button using Scriptaculous
      const ctaButton = document.querySelector('.cta');
      if (ctaButton) {
        setTimeout(() => {
          if (typeof Effect !== 'undefined') {
            new Effect.Pulsate(ctaButton, { duration: 2.0, pulses: 3 });
          } else {
            pulsate(ctaButton, 2000, 2);
          }
        }, 1000);
      }
      
      // 3. Animate cards with Scriptaculous appear effect
      cards.forEach((card, index) => {
        if (!card.id) card.id = 'card-' + index;
        card.style.display = 'none';
        setTimeout(() => {
          if (typeof Effect !== 'undefined') {
            new Effect.Appear(card.id, { duration: 0.5, delay: index * 0.1 });
          } else {
            card.style.display = '';
            appear(card);
          }
        }, index * 200);
      });
      
      // 4. Dynamically modify card styles on hover (already in events.js but adding here too)
      cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
          setStyle(card, {
            transform: 'translateY(-5px) scale(1.02)',
            boxShadow: '0 15px 40px rgba(96,165,250,0.4)'
          });
        });
        
        card.addEventListener('mouseleave', () => {
          setStyle(card, {
            transform: '',
            boxShadow: ''
          });
        });
      });
      
      // 5. Remove welcome message after 5 seconds with fade out
      setTimeout(() => {
        if (welcomeMsg.parentNode) {
          removeElement(welcomeMsg);
        }
      }, 5000);
    });
  </script>
</section>


<section class="section">
  <div class="container">
    <h2>Галерея</h2>
    <?php $photos = list_gallery_photos(15); ?>
    <?php if (empty($photos)): ?>
      <p>Добавьте файлы <code>photo1.jpg</code>, <code>photo2.png</code>, ... в папку <code>assets/photos</code>.</p>
    <?php else: ?>
      <div class="carousel mt-3" id="carousel" data-photos='<?= json_encode($photos, JSON_UNESCAPED_SLASHES) ?>'>
        <div class="carousel-main">
          <img id="carousel-main" src="<?php echo h($photos[0]); ?>" alt="Marathon photo">
          <button class="carousel-btn prev" type="button" id="btn-prev">&#10094;</button>
          <button class="carousel-btn next" type="button" id="btn-next">&#10095;</button>
        </div>
        <div class="carousel-thumbs" id="carousel-thumbs">
          <?php foreach ($photos as $idx => $p): ?>
            <img src="<?php echo h($p); ?>" data-index="<?php echo $idx; ?>" class="<?php echo $idx===0?'active':''; ?>" alt="thumb">
          <?php endforeach; ?>
        </div>
      </div>
      <script>
        (function(){
          const wrap = document.getElementById('carousel');
          if (!wrap) return;
          const photos = JSON.parse(wrap.getAttribute('data-photos'));
          let i = 0;
          const main = document.getElementById('carousel-main');
          const thumbs = document.getElementById('carousel-thumbs');
          function setIndex(n){
            i = (n + photos.length) % photos.length;
            main.src = photos[i];
            Array.from(thumbs.querySelectorAll('img')).forEach((img, idx)=>{
              if (idx===i) img.classList.add('active'); else img.classList.remove('active');
            });
          }
          document.getElementById('btn-prev').addEventListener('click', ()=> setIndex(i-1));
          document.getElementById('btn-next').addEventListener('click', ()=> setIndex(i+1));
          thumbs.addEventListener('click', (e)=>{
            const t = e.target.closest('img[data-index]');
            if (!t) return; setIndex(parseInt(t.getAttribute('data-index')));
          });
          document.addEventListener('keydown', (e)=>{ 
            if (e.key==='ArrowLeft') setIndex(i-1); 
            if (e.key==='ArrowRight') setIndex(i+1); 
          });
        })();
      </script>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>Partners</h2>
    <div class="partners mt-3">
      <?php $logos = list_sponsor_logos(20); if (empty($logos)): ?>
        <p>Upload files named <code>sponsor1.png</code>, <code>sponsor2.jpg</code>, ... into <code>assets/photos</code>.</p>
      <?php else: foreach ($logos as $logo): ?>
        <img src="<?php echo h($logo); ?>" alt="Partner">
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
