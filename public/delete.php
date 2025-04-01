<?php
session_start();
require_once __DIR__ . '/../src/db.php';

// 🔐 Admin-only access
if ($_SESSION['user']['user_type'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

$error = '';
$success = '';

// 🗑️ Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    if ($userId == $_SESSION['user']['id']) {
        $error = "You can't delete your own account.";
    } else {
        try {
            $stmt = getDb()->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $success = "User deleted successfully.";
        } catch (PDOException $e) {
            $error = "Error deleting user: " . $e->getMessage();
        }
    }
}

$stmt = getDb()->prepare("SELECT id, first_name, last_name, email, user_type FROM users WHERE id != ?");
$stmt->execute([$_SESSION['user']['id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete User</title>
  <link rel="stylesheet" href="/css/main.css">
  <style>
    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f0f0f0;
    }
    .delete-btn {
      background: #e74c3c;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
      cursor: pointer;
    }
    .delete-btn:hover {
      background: #c0392b;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .error {
      color: #c0392b;
    }
    .success {
      color: #27ae60;
    }
    a.back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #3498db;
      text-decoration: none;
    }
    a.back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Manage Users - Delete</h2>

    <?php if ($error): ?>
      <p class="message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
      <p class="message success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['user_type']) ?></td>
          <td>
            <form method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
              <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
              <button class="delete-btn" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <a class="back-link" href="index.php">← Back to Dashboard</a>
  </div>
</body>
</html>
