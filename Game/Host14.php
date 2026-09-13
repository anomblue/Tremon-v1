<?php
require_once('../api/ronfig.php');

$script = '
game:Load("http://localhost/Game/Maps/1.rbxl")
Port = 53640
Server =  game:GetService("NetworkServer") 
HostService = game:GetService("RunService")Server:Start(Port,20) 
game:GetService("RunService"):Run()
';

echo sign15($script);
?>