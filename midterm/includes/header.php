<?php require_once dirname(__DIR__) . '/includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($pageTitle ?? 'Eventify'); ?></title>
    <link rel="stylesheet" href="<?php echo '/assets/css/style.css'; ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div class="logo">Eventify</div>
        <?php include dirname(__DIR__) . '/includes/nav.php'; ?>
    </div>
</header>


