<?php
require_once 'db.php';

function login($email, $password) {
    $pdo = getDb();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $sessionId = generate_uuid_v4();

        $_SESSION['user'] = [
            'session_id' => $sessionId,
            'id' => $user['id'],
            'name' => $user['first_name'],
            'user_type' => $user['user_type'],
            'email' => $user['email']
        ];

        try {
            $insert = $pdo->prepare("INSERT INTO sessions (user_id, session_id) VALUES (?, ?)");
            $insert->execute([$user['id'], $sessionId]);
            error_log("✅ Session inserted for user ID {$user['id']}");
        } catch (PDOException $e) {
            error_log("❌ Session insert failed: " . $e->getMessage());
        }

        return true;
    }

    return false;
}


function isLoggedIn() {
    return isset($_SESSION['user']);
}

function logout() {
    session_destroy();
}

function generate_uuid_v4() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000, // version 4
        mt_rand(0, 0x3fff) | 0x8000, // variant
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

