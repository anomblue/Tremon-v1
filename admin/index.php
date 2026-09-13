<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/config.php');

if ($_SESSION['uid'] !== 1) {
    http_response_code(403);
    die('403 - Forbidden');
}

$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE lastseen >= NOW() - INTERVAL 1 MINUTE");
$allonline = $stmt->fetchColumn();

include('./nav.php');

$stmt = $pdo->query("
    SELECT uid, name, lastseen
    FROM users
    WHERE lastseen >= NOW() - INTERVAL 1 MINUTE
    ORDER BY name
");

$online = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($online as $user) {
    echo "onlin-  " . htmlspecialchars($user['name']) . "<br>";
}

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE isban = 1");
$banned = $stmt->fetchColumn();
?>

<h1>admin panel</h1>
if ur an admin and looking at this monstrosity blame 4am version of me
<h1>statistice</h1>
<h2>users: <?=$total?></h2>
<h2>online: <?=$allonline?></h2>
<h2>banned: <?=$banned?></h2>