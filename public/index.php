<?php
session_start();
require_once __DIR__ . '/../src/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../templates/header.php';
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['user']['name']?? 'Username not found') ?>!</h1>
<p>You are logged in.</p>
<div class="screens">
  <a href="logout.php">Log out</a>
  <a href="changepw.php">Change Password</a>
  <?php if($_SESSION['user']['user_type'] === 'admin'):?>
    <a href="register.php">Register User</a>
    <a href="delete.php">Delete User</a>
    <a href="update.php">Update User</a>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>


