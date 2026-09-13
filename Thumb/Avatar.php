<?php
if (!isset($_GET['id'])) {
    header('Location: /images/fail.png');
    exit;
}

$id = (int) $_GET['id'];

$file = $_SERVER['DOCUMENT_ROOT'] . '/images/avatars/avatar_' . $id . '.png';

if (!file_exists($file)) {
    header('Location: /images/fail.png');
    exit;
}

header('Content-Type: image/png');
echo file_get_contents($file);
?>