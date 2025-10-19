<?php 
require_once dirname(__DIR__) . '/includes/functions.php';
$pageTitle = 'Login — Eventify'; 
include dirname(__DIR__) . '/includes/header.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        $result = login_user($email, $password);
        if ($result['success']) {
            header('Location: /public/dashboard.php');
            exit;
        } else {
            $error = $result['error'];
        }
    }
}
?>

<section class="section">
  <div class="container">
    <div class="card" style="max-width: 500px; margin: 0 auto;">
      <div class="content">
        <h2>Login</h2>
        
        <?php if ($error): ?>
            <div style="color: #ef4444; background: #1f2937; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                <?php echo h($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
          <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="<?php echo h($_POST['email'] ?? ''); ?>" required>
          </div>
          <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
          </div>
          <button type="submit">Login</button>
        </form>
        
        <p style="margin-top: 16px; text-align: center;">
            Don't have an account? <a href="/public/register.php">Register here</a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
