<?php $pageTitle = 'Registration Successful — Eventify'; include dirname(__DIR__) . '/includes/header.php'; ?>
<section class="section">
  <div class="container">
    <h2>Thank you, <?php echo h($_GET['name'] ?? ''); ?>!</h2>
    <p>Your registration has been received. A confirmation email will be sent if provided.</p>
    <p class="mt-3"><a class="btn" href="/public/events.php">Back to Events</a></p>
  </div>
</section>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>


