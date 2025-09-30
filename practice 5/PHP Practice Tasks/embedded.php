<?php

session_start();

$name = "Ilyas";
$startAge = 22;

if (!isset($_SESSION['age'])) {
  $_SESSION['age'] = $startAge;
} else {
  $_SESSION['age'] += 1;
}
$age = $_SESSION['age'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My First PHP Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
    .card { border:1px solid #ddd; border-radius:12px; padding:16px; max-width:480px; }
    .muted{ color:#666; }
  </style>
</head>
<body>
  <div class="card">
    <h1>My First PHP Page</h1>
    <p>Hello, my name is <strong><?php echo htmlspecialchars($name); ?></strong>.</p>
    <p>My age (increments each refresh): <strong><?php echo $age; ?></strong></p>
    <p class="muted">Tip: age is stored in a PHP session (close the browser or call <code>reset_age.php</code> to reset).</p>
  </div>
</body>
</html>
