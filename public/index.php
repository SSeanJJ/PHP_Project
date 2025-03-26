<?php
session_start();
require_once __DIR__ . '/../src/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../templates/header.php';
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h1>
<p>You are logged in.</p>
<a href="logout.php">Log out</a>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
