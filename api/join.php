<?php

session_start();

if (!isset($_SESSION['name'])) {
    die('404');
}

if (!isset($_GET['gid'])) {
    die('404');
}

$gid = (int)$_GET['gid'];

$port = 2048 * $gid;

// require_once('./startserver.php');

if ($_SESSION['uid'] == 0) {
    header(
    'Location: tremon://join?port=' . urlencode($port) .
    '&uid=' . urlencode($_SESSION['name'])
    );
} else {
    header(
    'Location: tremon://join?port=' . urlencode($port) .
    '&uid=' . urlencode($_SESSION['uid'])
    );
}
exit;

?>