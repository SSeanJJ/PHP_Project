<?php
session_start();
require_once __DIR__ . '/../src/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!$currentPassword || !$newPassword || !$confirmPassword) {
        $error = 'All fields are required.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match.';
    } else {
        $pdo = getDb();
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user']['id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
            $error = 'Current password is incorrect.';
        } else {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $update->execute([$newHash, $_SESSION['user']['id']]);
            $success = 'Password updated successfully.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <link rel="stylesheet" href="/css/main.css">
</head>
<body>
  <div class="container" style="max-width: 600px; margin: 40px auto;">
    <h2>Change Password</h2>

    <?php if ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
      <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
      <input type="password" name="current_password" placeholder="Current Password" required><br><br>
      <input type="password" name="new_password" placeholder="New Password" required><br><br>
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br><br>
      <button type="submit">Update Password</button>
    </form>

    <p><a href="index.php">← Back to Dashboard</a></p>
  </div>
</body>
</html>
