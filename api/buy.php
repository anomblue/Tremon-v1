<?php
session_start();
include('./config.php');

if (!isset($_GET['id'])) {
    header('Location: /404');
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM catalog WHERE id = ?");
$stmt->execute([$id]);

$asset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$asset) {
    header('Location: /404');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
$stmt->execute([$_SESSION['uid']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT 1 FROM inventory WHERE uid = ? AND asset = ?");
$stmt->execute([$_SESSION['uid'], $asset['id']]);

if ($stmt->fetch()) {
    die('u own dis dum dum');
}

if ($user['rbx'] < $asset['rbx'] || $user['tix'] < $asset['tix']) {
    die('ur 2 poor');
}

$newrbx = $user['rbx'] - $asset['rbx'];
$newtix = $user['tix'] - $asset['tix'];

$stmt = $pdo->prepare("UPDATE users SET rbx = ?, tix = ? WHERE uid = ?");
$stmt->execute([$newrbx, $newtix, $_SESSION['uid']]);

$stmt = $pdo->prepare("INSERT INTO inventory (uid, asset) VALUES (?, ?)");
$stmt->execute([$_SESSION['uid'], $asset['id']]);

header("Location: /Item?id=" . $id);