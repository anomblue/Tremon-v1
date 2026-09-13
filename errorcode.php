<?php
if (!isset($_GET['ec'])) {
    die('please do ?ec=[errorcode]');
}

$ec = (int) $_GET['ec'];

http_response_code($ec);