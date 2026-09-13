<?php
session_start();
require_once('./config.php');
//require_once('./antivpn.php');

$name = $_POST['n'];
$pass = $_POST['p'];
$conf = $_POST['c'];
$invite = $_POST['i'];

// captcha logic here

if ($verifres === false) {
    die('captcha fail');
}

$captcha = json_decode($verifres, true);

if (empty($captcha['success'])) {
    die('captcha fail');
}

$stmt = $pdo->prepare("SELECT invitekey FROM invitekeys WHERE invitekey = ? LIMIT 1");
$stmt->execute([$invite]);

$inviteRow = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$inviteRow) {
    die("invalid invite key");
}

if ($pass != $conf) {
    die('passwords dont match');
}

if (strlen($name) < 3) {
    die('name is less than characters');
}

if (strlen($name) > 15) {
    die('name is above 15 characters');
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
    die('name has special symbols');
}

if (strlen($pass) > 50) {
    die('password is above 50 characters');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
$stmt->execute([$name]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    die('username already exists');
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (name, pw) VALUES (?, ?)");
$stmt->execute([$name, $hash]);

$stmt = $pdo->prepare("DELETE FROM invitekeys WHERE `invitekey` = ?");
$stmt->execute([$invite]);
echo 'success';
header('Location: /login');
exit;
?>