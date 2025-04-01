<?php
session_start();
require_once __DIR__ . '/../src/db.php';

$is_admin = isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'admin';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $user_type = $is_admin ? trim($_POST['user_type']) : 'user';  // Public users default to 'user'
    $date = date('Y-m-d');

    if ($first_name && $last_name && $email && $password) {
        $stmt = getDb()->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if ($user_type === "admin") {
                $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash, user_type, start_date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $hash, $user_type, $date]);
            } elseif ($user_type === "user") {
                $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash, user_type, registration_date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $hash, $user_type, $date]);
            } else { // hybrid
                $stmt = getDb()->prepare("INSERT INTO users (first_name, last_name, email, password_hash, user_type, start_date, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $hash, $user_type, $date, $date]);
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

    <?php if ($is_admin): ?>
      <select name="user_type" required>
        <option value="" disabled selected>Select User Type</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
        <option value="hybrid">Hybrid</option>
      </select><br>
    <?php else: ?>
      <input type="hidden" name="user_type" value="user">
      <p>You are registering as a regular user.</p>
    <?php endif; ?>

    <input name="password" type="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>

<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<footer>CMSC_4003 By Sean Jaeger</footer>
</body>
</html>
