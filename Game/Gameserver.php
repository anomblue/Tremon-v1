<?php
require_once('../api/ronfig.php');

if (!isset($_GET['port'])) {
    header('Location: /');
}

$port = (int) $_GET['port'];

if (!isset($_GET['gid'])) {
    header('Location: /');
}

$gid = (int) $_GET['gid'];

$script = '
game:Load("http://n.cloudpub.ru/Game/Maps/' . $gid . '.rbxl")
Port = ' . $port . '
Server =  game:GetService("NetworkServer")
HostService = game:GetService("RunService")Server:Start(Port,20)
game:GetService("RunService"):Run()
';

echo sign($script);
?>