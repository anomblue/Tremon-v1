<?php
session_start();
require_once './config.php';

if (!isset($_POST['d'])) {
    die('super duper fatal error');
}

$desc = $_POST['d'];
if (strlen($desc) > 50 ) {
    die('i would be stupid to not add protection');
}

$stmt = $pdo->prepare("UPDATE users SET description = ? WHERE uid = ?");
$stmt->execute([$desc, $_SESSION['uid']]);

header("Location: /profile?id=" . $_SESSION['uid']);
exit;