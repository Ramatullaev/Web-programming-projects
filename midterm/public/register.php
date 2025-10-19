<?php 
require_once dirname(__DIR__) . '/includes/functions.php';
$pageTitle = 'Register — Eventify'; 
include dirname(__DIR__) . '/includes/header.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        $result = register_user($name, $email, $password, $phone);
        if ($result['success']) {
            $success = 'Registration successful! Please login.';
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
        <h2>Create Account</h2>
        
        <?php if ($error): ?>
            <div style="color: #ef4444; background: #1f2937; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                <?php echo h($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="color: #22d3ee; background: #1f2937; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                <?php echo h($success); ?>
                <div style="margin-top: 12px;">
                    <a class="btn" href="/public/login.php">Go to Login</a>
                </div>
            </div>
        <?php else: ?>
        
        <form method="post">
          <div>
            <label for="name">Full Name</label>
            <input id="name" name="name" value="<?php echo h($_POST['name'] ?? ''); ?>" required>
          </div>
          <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="<?php echo h($_POST['email'] ?? ''); ?>" required>
          </div>
          <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
          </div>
          <div>
            <label for="phone">Phone (Optional)</label>
            <input id="phone" name="phone" value="<?php echo h($_POST['phone'] ?? ''); ?>">
          </div>
          <button type="submit">Register</button>
        </form>
        
        <p style="margin-top: 16px; text-align: center;">
            Already have an account? <a href="/public/login.php">Login here</a>
        </p>
        
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>