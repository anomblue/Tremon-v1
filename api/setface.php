<?php
session_start();
require_once './config.php';

if (!isset($_GET['id'])) {
    die('super duper fatal error');
}

$face = $_GET['id'];

$stmt = $pdo->prepare("UPDATE users SET face = ? WHERE uid = ?");
$stmt->execute([$face, $_SESSION['uid']]);

header("Location: /Avatar");
exit;