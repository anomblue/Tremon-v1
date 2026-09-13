<?php
session_start();
require_once './config.php';

if (!isset($_GET['id'])) {
    die('super duper fatal error');
}

$hat = $_GET['id'];

$stmt = $pdo->prepare("UPDATE users SET hat = ? WHERE uid = ?");
$stmt->execute([$hat, $_SESSION['uid']]);

header("Location: /Avatar");
exit;