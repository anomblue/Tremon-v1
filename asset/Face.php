<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');
if (!isset($_GET['userId'])) {
    exit;
}

$id = (int) $_GET['userId'];

if ($id == 0) {
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$faceid = (int) $user['face'];

if ($faceid == 0) {
    exit;
}

header("Content-Type: application/xml");

echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/asset/storage/" . $faceid);