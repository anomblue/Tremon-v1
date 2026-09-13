<?php
session_start();
require_once('./config.php');
require_once('./antivpn.php');

$name = $_POST['n'];
$pass = $_POST['p'];

if (strlen($name) > 15) {
    die('name is above 15 characters');
}

if (strlen($pass) > 50) {
    die('password is above 50 characters');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
$stmt->execute([$name]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($pass, $user['pw'])) {
    $_SESSION['name'] = $user['name'];
    $_SESSION['uid'] = $user['uid'];

    header('Location: /');
    exit;
}

die('name or password is incorrect');