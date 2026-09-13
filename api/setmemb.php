<?php
session_start();
require_once './config.php';

if (!isset($_POST['m'])) {
    die('super duper fatal error');
}

$m = (int)$_POST['m'];

if (!in_array($m, range(0, 3), true)) {
    die('Account deleting in 1 millisecond...');
}

$stmt = $pdo->prepare("UPDATE users SET membership = ? WHERE uid = ?");
$stmt->execute([$m, $_SESSION['uid']]);

header("Location: /settings");
exit;