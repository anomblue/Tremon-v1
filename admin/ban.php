<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');

if ($_SESSION['uid'] !== 1) {
    http_response_code(403);
    die('403 - Forbidden');
}

$uid = $_POST['uid'];
$r = $_POST['r'];

$stmt = $pdo->prepare("UPDATE users SET isban = 1, banreas = ? WHERE uid = ?");
$stmt->execute([$r, $uid]);

header("Location: /Admin/Users.php");