<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');

if ($_SESSION['uid'] !== 1) {
    http_response_code(403);
    die('403 - Forbidden');
}

$uid = (int)$_POST['uid'];
$n = $_POST['n'];

$stmt = $pdo->prepare("
    UPDATE users
    SET name = ?
    WHERE uid = ?
");

$stmt->execute([$n, $uid]);

header("Location: /Admin/Users.php");
exit;