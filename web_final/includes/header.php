<?php
require_once __DIR__ . '/config.php';
$currentTheme = getTheme();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Kazakh Cuisine & Booking'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/<?php echo $currentTheme; ?>.css">
</head>
<body class="theme-<?php echo $currentTheme; ?>">
    <header>
        <nav>
            <div class="nav-container">
                <div class="logo">
                    <h1>Kazakh Cuisine</h1>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="portfolio.php">Portfolio</a></li>
                    <li><a href="portfolio.php#booking">Book Now</a></li>
                    <li><a href="add_portfolio_item.php">Add Item</a></li>
                </ul>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                    <span id="themeIcon">🌙</span>
                </button>
            </div>
        </nav>
    </header>
    <main>

