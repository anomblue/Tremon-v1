<?php
//die('down');
session_start();
if (!isset($_SESSION['uid'])) {
    die('404');
}
$file = "RV2.rar";
$newName = "TremonReleaseV2.rar";

$path = $_SERVER['DOCUMENT_ROOT'] . "/versions/" . $file;

if (file_exists($path)) {
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$newName\"");
    header("Content-Length: " . filesize($path));

    readfile($path);
    exit;
}

echo "err";
?>