<?php
session_start();
require_once './config.php';

if (!isset($_GET['c'])) {
    die('super duper fatal error');
}

if (!isset($_GET['t'])) {
    die('super duper fatal error');
}

$c = $_GET['c'];
$ctype = $_GET['t'];

$allowed = [
    'hc',
    'tc',
    'lac',
    'rac',
    'llc',
    'rlc'
];

if (!in_array($ctype, $allowed, true)) {
    die('evil color');
}

$stmt = $pdo->prepare("UPDATE users SET " . $ctype . " = ? WHERE uid = ?");
$stmt->execute([$c, $_SESSION['uid']]);

header("Location: /Avatar");
exit;