<?php
session_start();
require_once __DIR__ . '/../src/db.php';

// redirect non admins away from page
if ($_SESSION['user']['user_type'] === 'admin') {
} else {
  header('Location: unauthorized.php');
  exit;
}

$db = getDb();
$error = '';
$success = '';
$selected_user = null;

// Handle user selection
if (isset($_POST['select_user'])) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_POST['user_id']]);
    $selected_user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle update form submission
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $user_type = trim($_POST['user_type']);

    if ($first_name && $last_name && $email && $user_type) {
        $stmt = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, user_type = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $email, $user_type, $id]);
        $success = "User updated successfully.";
    } else {
        $error = 'All fields required.';
    }
}

// Fetch all users for the dropdown
$users = $db->query("SELECT id, email FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update User</title>
  <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<h2>Update User</h2>

<form method="post">
  <label>Select User:</label><br>
  <select name="user_id" required>
    <option value="" disabled selected>Choose an email</option>
    <?php foreach ($users as $user): ?>
      <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['email']) ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" name="select_user">Select</button>
</form>

<?php if ($selected_user): ?>
<hr>
<form method="post">
    <input type="hidden" name="id" value="<?= $selected_user['id'] ?>">
    <input name="first_name" type="text" value="<?= htmlspecialchars($selected_user['first_name']) ?>" required><br>
    <input name="last_name" type="text" value="<?= htmlspecialchars($selected_user['last_name']) ?>" required><br>
    <input name="email" type="email" value="<?= htmlspecialchars($selected_user['email']) ?>" required><br>
    <select name="user_type" required>
        <option value="admin" <?= $selected_user['user_type'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="user" <?= $selected_user['user_type'] === 'user' ? 'selected' : '' ?>>User</option>
        <option value="hybrid" <?= $selected_user['user_type'] === 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
    </select><br>
    <button type="submit" name="update_user">Update User</button>
</form>
<?php endif; ?>

<?php if ($error): ?>
  <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if ($success): ?>
  <p style="color:green"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<footer>CMSC_4003 By Sean Jaeger</footer>
</body>
</html>
