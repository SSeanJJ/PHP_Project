<?php
session_start();
require_once __DIR__ . '/../src/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../templates/header.php';
?>

<h1> The page you're requesting is restricted (<?= htmlspecialchars($_SESSION['user']['user_type']?? '') ?>s) are not allowed!</h1>
<p>You are logged in.</p>
<a href="logout.php">Log out</a>
<a href="index.php">Home</a>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
