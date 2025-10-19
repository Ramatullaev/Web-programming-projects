<?php $pageTitle = 'Contact — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="section">
  <div class="container">
    <h2>Contact Us</h2>
    <p class="mt-2">Have questions about registration, routes, or volunteering? Reach out.</p>
    <div class="grid mt-3" style="grid-template-columns: 2fr 3fr; gap: 16px;">
      <div class="card"><div class="content">
        <p><strong>Email:</strong> support@eventify.local</p>
        <p><strong>Phone:</strong> +7 (777) 000-00-00</p>
        <p><strong>Address:</strong> Алматы, площадь Республики</p>
      </div></div>
      <div>
        <form method="post" onsubmit="alert('Thanks! We will get back to you soon.'); return false;">
          <div>
            <label for="cname">Your name</label>
            <input id="cname" required>
          </div>
          <div>
            <label for="cemail">Email</label>
            <input id="cemail" type="email" required>
          </div>
          <div>
            <label for="cmsg">Message</label>
            <input id="cmsg" required>
          </div>
          <button type="submit">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


