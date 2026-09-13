<?php
session_start();
$_SESSION['name'] = "Guest " . rand(1,9999);
$_SESSION['uid'] = 0;

header('Location: /');