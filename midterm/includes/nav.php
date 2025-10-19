<nav class="site-nav">
    <a href="/public/index.php">Home</a>
    <a href="/public/events.php">Events</a>
    <a href="/public/contact.php">Contact</a>
    <?php if (is_logged_in()): ?>
        <a href="/public/dashboard.php">My Marathons</a>
        <a href="/public/logout.php">Logout</a>
    <?php else: ?>
        <a href="/public/login.php">Login</a>
        <a href="/public/register.php">Register</a>
    <?php endif; ?>
    <a href="/public/admin.php">Admin</a>
</nav>


