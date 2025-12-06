<?php 
require_once dirname(__DIR__) . '/includes/functions.php';
logout_user();
header('Location: /public/index.php');
exit;
?>
