<?php
session_start();
require_once __DIR__ . '/../src/auth.php';
logout();
header('Location: login.php');
exit;
