<?php
session_start();
require_once __DIR__ . '/../src/db.php';

// redirect non admins away from page
if ($_SESSION['user']['user_type'] === 'admin') {
} else {
  header('Location: unauthorized.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $user_type= trim($_POST['user_type']);
    $date = date('Y-m-d');

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($first_name && $last_name && $user_type && $email && $password) {
        $stmt = getDb()->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if($user_type === "admin"){
              $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash, start_date) VALUES (?, ?, ?)");
              $stmt->execute([$first_name, $last_name, $email, $hash, $date]);
            } elseif ($user_type === "user") {
              $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash, registration_date) VALUES (?, ?, ?)");
              $stmt->execute([$first_name, $last_name, $email, $hash, $date]);
            } else { //hybrid
              $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?, ?, ?)");
              $stmt->execute([$first_name, $last_name, $email, $hash]);
            }
            header('Location: login.php');
            exit;
        }
    } else {
        $error = 'All fields required.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<h2>Register</h2>
<form method="post">
    <input name="first_name" type="text" placeholder="First Name" required><br>
    <input name="last_name" type="text" placeholder="Last Name" required><br>
    <input name="email" type="email" placeholder="Email" required><br>
    <select name="user_type" required>
      <option value="" disabled selected>Select User Type</option>
      <option value="admin">Admin</option>
      <option value="user">User</option>
      <option value="hybrid">Hybrid</option>
    </select><br>
    <input name="password" type="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<footer>CMSC_4003 By Sean Jaeger</footer>
</body>
</html>
